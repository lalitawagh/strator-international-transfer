<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Helper;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\IpLogs;
use Kanexy\Cms\Notifications\SmsOneTimePasswordNotification;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\MoneyTransfer;
use Kanexy\InternationalTransfer\Enums\PaymentMethod;
use Kanexy\InternationalTransfer\Http\Requests\MoneyTransferRequest;
use Kanexy\InternationalTransfer\Mail\InternationalTransferDebitAlertEmail;
use Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy;
use Kanexy\PartnerFoundation\Core\Enums\TransactionStatus;
use Kanexy\Banking\Models\Account;
use Kanexy\PartnerFoundation\Core\Facades\PartnerFoundation;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Models\Log;
use Kanexy\PartnerFoundation\Core\Services\TotalProcessingService;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Kanexy\PartnerFoundation\Dashboard\Notification\ThresholdExceededNotification;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Kanexy\PartnerFoundation\Workspace\Enums\WorkspaceStatus;
use Kanexy\InternationalTransfer\Notifications\RiskAssessmentNotification;
use Kanexy\Cms\Notifications\EmailOneTimePasswordNotification;
use Kanexy\PartnerFoundation\Core\Models\UserMeta;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;
use Kanexy\InternationalTransfer\Models\CcAccount;
use Kanexy\InternationalTransfer\Notifications\MoneyTransferRequestNotification;
use Kanexy\PartnerFoundation\Workspace\Models\WorkspaceMeta;
use Stripe;
use PDF;
use Kanexy\InternationalTransfer\Services\CurrencyCloudService;
use Kanexy\Cms\Models\UserSetting;

class MoneyTransferController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::VIEW, MoneyTransfer::class);

        session()->forget('transaction_id');

        session()->forget('money_transfer_request');

        $transactions = QueryBuilder::for(Transaction::class);

        $user = Auth::user();
        $workspace = null;

        if ($request->has('filter.workspace_id')) {
            $workspace = Workspace::findOrFail($request->input('filter.workspace_id'));
        }


        if(!is_null($request->input('id')))
        {
            $transactionBeneficary= Transaction::find($request->input('id'));
            $transactions = $transactions->where('meta->second_beneficiary_bank_account_number',$transactionBeneficary->meta['second_beneficiary_bank_account_number'])->where("meta->transaction_type", 'money_transfer')->latest()->paginate();
        }else
        {
            $transactions = $transactions->where("meta->transaction_type", 'money_transfer')->latest()->paginate();
        }

        return view('international-transfer::money-transfer.index', compact('transactions','user','workspace'));
    }

    public function review(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::VIEW, MoneyTransfer::class);

        session()->forget('transaction_id');

        session()->forget('money_transfer_request');

        $transactions = QueryBuilder::for(Transaction::class)
            ->allowedFilters([
                AllowedFilter::exact('workspace_id'),
            ]);

        $user = Auth::user();
        $workspace = null;
        $limit = Setting::getValue('transaction_threshold_amount', []);

        if ($request->has('filter.workspace_id')) {
            $workspace = Workspace::findOrFail($request->input('filter.workspace_id'));
        }

        $transactions = $transactions->where('amount', '>', $limit)->where("meta->transaction_type", 'money_transfer')->whereIn('status', [TransactionStatus::DRAFT, TransactionStatus::PENDING])->latest()->paginate();

        return view('international-transfer::money-transfer.transactionreviewlist', compact('transactions', 'user'));
    }

    public function create(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);
        session()->forget('transaction_id');

        $user = Auth::user();
        $workspace = Workspace::findOrFail($request->input('filter.workspace_id'));
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));

        return view('international-transfer::money-transfer.process.create', compact('countries', 'defaultCountry', 'workspace', 'user'));
    }

    public function store(MoneyTransferRequest $request)
    {
        $user = Auth::user();
        $workspace = Workspace::findOrFail($request->input('workspace_id'));
        $workspaceMeta = WorkspaceMeta::where(['workspace_id' => $workspace->id, 'key' => 'skip_kyc'])->first();

        if($user->is_banking_user != 2){
            if ($workspace->status == WorkspaceStatus::INACTIVE){
                    return redirect()->back();
            }
        }


        $data = $request->validated();

        $existSessionRequest = session('money_transfer_request');

        if (!is_null(session('money_transfer_request'))) {

            $data['beneficiary_id'] = isset($existSessionRequest['beneficiary_id'])
                ? $existSessionRequest['beneficiary_id']
                : null;

            $data['transaction'] = isset($existSessionRequest['transaction'])
                ? $existSessionRequest['transaction']
                : null;

            $data['payment_method'] = isset($existSessionRequest['payment_method'])
                ? $existSessionRequest['payment_method']
                : null;

            $data['transfer_reason'] = isset($existSessionRequest['transfer_reason'])
                ? $existSessionRequest['transfer_reason']
                : null;
        }

        session(['money_transfer_request' => $data]);

        return redirect()->route('dashboard.international-transfer.money-transfer.beneficiary', ['filter' => ['workspace_id' => $request->input('workspace_id')]]);
    }

    public function showBeneficiary()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        if (is_null(session('money_transfer_request'))) {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]);
        }

        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $beneficiaries = Contact::beneficiaries()->verified()->forWorkspace($workspace)->whereRefType('money_transfer')->orderBy('id', 'desc')->take(5)->get();

        return view('international-transfer::money-transfer.process.beneficiary', compact('user', 'countries', 'defaultCountry', 'workspace', 'beneficiaries'));
    }

    public function beneficiaryStore()
    {
        $user = Auth::user();
        $workspace = $user->workspaces()->first();

        return redirect()->route('dashboard.international-transfer.money-transfer.beneficiary', ['filter' => ['workspace_id' => $workspace->id]])->withErrors(['beneficiary' => 'Please create or select beneficiary']);
    }

    public function showPaymentMethod(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        if (is_null(session('money_transfer_request'))) {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]);
        }

        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $transferDetails = session('money_transfer_request');
        $sender =  $transferDetails ? Country::find($transferDetails['currency_code_from']) : null;
        $receiver = $transferDetails ? Country::find($transferDetails['currency_code_to']) : null;
        $totalAmount =  $transferDetails ? ($transferDetails['amount'] - $transferDetails['fee_charge']) : 0;
        $reasons = collect(Setting::getValue('money_transfer_reasons', []));
        $masterAccount =  collect(Setting::getValue('money_transfer_master_account_details', []))->firstWhere('country', $sender->id);
        $riskInfo = collect(Setting::getValue('risk_assessment',[]));

        return view('international-transfer::money-transfer.process.payment', compact('user', 'countries', 'defaultCountry', 'workspace', 'sender', 'receiver', 'transferDetails', 'totalAmount', 'reasons', 'masterAccount', 'riskInfo'));
    }

    public function transactionDetail(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        if (is_null(session('money_transfer_request'))) {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]);
        }

        $data = $request->validate([
            'transfer_reason' => ['required', 'string'],
            'payment_method'  => ['required', 'string'],
            'delivery_method'  => ['required', 'string'],
            'source_of_fund' => ['nullable', 'string']
        ]);

        $transferDetails = session('money_transfer_request');
        $sender =  $transferDetails ? Country::find($transferDetails['currency_code_from']) : null;
        $receiver = $transferDetails ? Country::find($transferDetails['currency_code_to']) : null;
         /** @var \App\Models\User $user */
        $user = Auth::user();
        $workspace = $transferDetails ? Workspace::find($transferDetails['workspace_id']) : $request->input('filter.workspace_id');

        $secondBeneficiary = $transferDetails ? Contact::find($transferDetails['beneficiary_id']) : null;

        if (!is_null(PartnerFoundation::getBankingPayment($request))) {
            $account = Account::forHolder($workspace)->first();
            if ($data['payment_method'] == PaymentMethod::BANK_ACCOUNT) {
                if ($transferDetails['amount'] > $account?->balance) {
                    return redirect()->route('dashboard.international-transfer.money-transfer.payment', ['filter' => ['workspace_id' => $transferDetails['workspace_id']]])->withErrors(
                        ['payment_method' => 'Insufficient account balance.']
                    );
                }
            }
        }

        if ($data['payment_method'] == PaymentMethod::MANUAL_TRANSFER) {
            $transactionExist = isset($transferDetails['transaction']) ?  $transferDetails['transaction'] : null;
            $transaction = Transaction::updateOrCreate([
                'id' => $transactionExist?->id,
            ], [
                'urn' => Transaction::generateUrn(),
                'amount' => $transferDetails['amount'],
                'workspace_id' => $transferDetails['workspace_id'],
                'type' => 'debit',
                'payment_method' => $data['payment_method'],
                'note' => null,
                'ref_id' =>  $user->id,
                'ref_type' => 'money_transfer',
                'settled_amount' => $transferDetails['amount'],
                'settled_currency' => $sender['currency'],
                'settlement_date' => date('Y-m-d'),
                'transaction_fee' => $transferDetails['fee_charge'],
                'status' => TransactionStatus::DRAFT,
                'archived' => 0,
                'meta' => [
                    'reference_no' => MoneyTransfer::generateUrn(),
                    'sender_id' => $workspace->id,
                    'sender_name' => $workspace->name,
                    'beneficiary_id' => $transferDetails['beneficiary_id'],
                    'exchange_rate' => $transferDetails['guaranteed_rate'],
                    'base_currency' => $sender['currency'],
                    'exchange_currency' => $receiver['currency'],
                    'recipient_amount' => $transferDetails['recipient_amount'],
                    'second_beneficiary_name' => Helper::removeExtraSpace($secondBeneficiary?->meta['bank_account_name']),
                    'second_beneficiary_bank_code' => @$secondBeneficiary?->meta['bank_code'] ?? null,
                    'second_beneficiary_bank_code_type' => @$secondBeneficiary?->meta['bank_code_type'],
                    'second_beneficiary_bank_account_number' => @$secondBeneficiary?->meta['bank_account_number'] ?? null,
                    'second_beneficiary_bank_iban' => @$secondBeneficiary?->meta['iban_number'] ?? null,
                    'second_beneficiary_bank_aba' => @$secondBeneficiary?->meta['aba_number'] ?? null,
                    'second_beneficiary_bank_bsb' => @$secondBeneficiary?->meta['bsb_number'] ?? null,
                    'second_beneficiary_bank_bic' => @$secondBeneficiary?->meta['bic_number'] ?? null,
                    'second_beneficiary_bank_cnaps' => @$secondBeneficiary?->meta['cnaps_number'],
                    'second_beneficiary_bank_ach_routing_number' => @$secondBeneficiary?->meta['ach_routing_number'] ?? null,
                    'reason' =>  $data['transfer_reason'],
                    'transaction_type' => 'money_transfer',
                    'delivery_method'=>$data['delivery_method']
                ],
                'archived' => 0,
            ]);
            $transferDetails['transaction'] = $transaction;


            $riskDetails = Setting::getValue('risk_assessment',[]);
            $limit = @$riskDetails['profile_risk_threshold'] ? @$riskDetails['profile_risk_threshold'] : 0;
            $additional_info = UserMeta::where(['key' =>'risk_mgt_additional_info','user_id' => $user->id])->first();
            $totalTransaction = Transaction::select(DB::raw('SUM(amount) AS totalAmount'))->where(['workspace_id' => $workspace->id,'ref_type' => 'money_transfer'])->first();
            $skipKycStatus = WorkspaceMeta::where(['workspace_id' => $workspace->id, 'key' => 'skip_kyc'])->first();

            if($skipKycStatus?->value == 'true')
            {
                    $transaction->status = 'pending-kyc';
                    $transaction->update();
            }
            else
            {
                if($totalTransaction->totalAmount > $limit && is_null($additional_info))
                {
                    $transaction->status = 'pending-review';
                    $transaction->update();

                }
            }


        }

        $transferDetails['payment_method'] = $data['payment_method'];
        $transferDetails['transfer_reason'] = $data['transfer_reason'];

        if(!is_null(@$data['source_of_fund']))
        {
            $transferDetails['source_of_fund'] = @$data['source_of_fund'];
        }

        session(['money_transfer_request' => $transferDetails]);

        return redirect()->route('dashboard.international-transfer.money-transfer.preview', ['filter' => ['workspace_id' => $transferDetails['workspace_id']]]);
    }

    public function preview(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        if (is_null(session('money_transfer_request'))) {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]);
        }

        $user = Auth::user();
        $transferDetails = session('money_transfer_request');
        $sender =  $transferDetails ? Country::find($transferDetails['currency_code_from']) : null;
        $receiver = $transferDetails ? Country::find($transferDetails['currency_code_to']) : null;
        $secondBeneficiary = $transferDetails ? Contact::find($transferDetails['beneficiary_id']) : null;
        $beneficiary = null;
        $transaction = null;
        $transferReason = null;
        if (isset($transferDetails['transaction'])) {
            $beneficiary = Contact::find($transferDetails['transaction']->meta['beneficiary_id']);
            $transaction = $transferDetails['transaction'];
        }
        $masterAccount =  collect(Setting::getValue('money_transfer_master_account_details', []))->firstWhere('country', $sender->id);
        $workspace = Workspace::findOrFail(session()->get('money_transfer_request.workspace_id'));
        $transferReason = collect(Setting::getValue('money_transfer_reasons', []))->firstWhere('id', $transferDetails['transfer_reason']);
        $subAccounts = CcAccount::where(['holder_id' => $workspace?->id,'ref_type' => 'currency_cloud'])->first();

        return view('international-transfer::money-transfer.process.preview', compact('user', 'transferDetails', 'beneficiary', 'masterAccount', 'workspace', 'transaction', 'transferReason', 'secondBeneficiary', 'sender', 'receiver','subAccounts'));
    }

    public function finalizeTransfer(Request $request)
    {
        if (is_null(session('money_transfer_request'))) {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]);
        }

        $transferDetails = session('money_transfer_request');
        $user = Auth::user();
        $sender =  $transferDetails ? Country::find($transferDetails['currency_code_from']) : null;
        $receiver = $transferDetails ? Country::find($transferDetails['currency_code_to']) : null;
        $secondBeneficiary = $transferDetails ? Contact::find($transferDetails['beneficiary_id']) : null;
        $workspace = $transferDetails ? Workspace::find($transferDetails['workspace_id']) : $request->input('filter.workspace_id');

        if ($transferDetails['payment_method'] == PaymentMethod::STRIPE) {
            $transactionExist = isset($transferDetails['transaction']) ?  $transferDetails['transaction'] : null;
            $transaction = Transaction::updateOrCreate([
                'id' => $transactionExist?->id,
            ], [
                'urn' => Transaction::generateUrn(),
                'amount' => $transferDetails['amount'],
                'workspace_id' => $transferDetails['workspace_id'],
                'type' => 'debit',
                'payment_method' => $transferDetails['payment_method'],
                'note' => null,
                'ref_id' =>  $user->id,
                'ref_type' => 'money_transfer',
                'settled_amount' => $transferDetails['amount'],
                'settled_currency' => $sender['currency'],
                'settlement_date' => date('Y-m-d'),
                'transaction_fee' => $transferDetails['fee_charge'],
                'status' => TransactionStatus::DRAFT,
                'archived' => 0,
                'meta' => [
                    'reference_no' => MoneyTransfer::generateUrn(),
                    'sender_id' => $workspace->id,
                    'sender_name' => $workspace->name,
                    'beneficiary_id' => $transferDetails['beneficiary_id'],
                    'exchange_rate' => $transferDetails['guaranteed_rate'],
                    'base_currency' => $sender['currency'],
                    'exchange_currency' => $receiver['currency'],
                    'recipient_amount' => $transferDetails['recipient_amount'],
                    'second_beneficiary_name' => @$secondBeneficiary?->meta['bank_account_name'],
                    'second_beneficiary_bank_code' => @$secondBeneficiary?->meta['bank_code'] ?? null,
                    'second_beneficiary_bank_code_type' => @$secondBeneficiary?->meta['bank_code_type'],
                    'second_beneficiary_bank_account_number' => @$secondBeneficiary?->meta['bank_account_number'] ?? null,
                    'second_beneficiary_bank_iban' => @$secondBeneficiary?->meta['iban_number'] ?? null,
                    'second_beneficiary_bank_aba' => @$secondBeneficiary?->meta['aba_number'] ?? null,
                    'second_beneficiary_bank_bsb' => @$secondBeneficiary?->meta['bsb_number'] ?? null,
                    'second_beneficiary_bank_bic' => @$secondBeneficiary?->meta['bic_number'] ?? null,
                    'second_beneficiary_bank_cnaps' => @$secondBeneficiary?->meta['cnaps_number'],
                    'second_beneficiary_bank_ach_routing_number' => @$secondBeneficiary?->meta['ach_routing_number'] ?? null,
                    'transaction_type' => 'money_transfer',
                    'reason' =>  $transferDetails['transfer_reason'],
                ],
                'archived' => 0,
            ]);

            $transferDetails['transaction'] = $transaction;
            session(['money_transfer_request' => $transferDetails]);

            return redirect()->route('dashboard.international-transfer.money-transfer.stripe', ['filter' => ['workspace_id' => $transferDetails['workspace_id']]]);
        } else if ($transferDetails['payment_method'] == PaymentMethod::TOTAL_PROCESSING) {
            $transactionExist = isset($transferDetails['transaction']) ?  $transferDetails['transaction'] : null;
            $transaction = Transaction::updateOrCreate([
                'id' => $transactionExist?->id,
            ], [
                'urn' => Transaction::generateUrn(),
                'amount' => $transferDetails['amount'],
                'workspace_id' => $transferDetails['workspace_id'],
                'type' => 'debit',
                'payment_method' => $transferDetails['payment_method'],
                'note' => null,
                'ref_id' =>  $user->id,
                'ref_type' => 'money_transfer',
                'settled_amount' => $transferDetails['amount'],
                'settled_currency' => $sender['currency'],
                'settlement_date' => date('Y-m-d'),
                'transaction_fee' => $transferDetails['fee_charge'],
                'status' => TransactionStatus::DRAFT,
                'archived' => 0,
                'meta' => [
                    'reference_no' => MoneyTransfer::generateUrn(),
                    'sender_id' => $workspace->id,
                    'sender_name' => $workspace->name,
                    'beneficiary_id' => $transferDetails['beneficiary_id'],
                    'exchange_rate' => $transferDetails['guaranteed_rate'],
                    'base_currency' => $sender['currency'],
                    'exchange_currency' => $receiver['currency'],
                    'recipient_amount' => $transferDetails['recipient_amount'],
                    'second_beneficiary_name' => @$secondBeneficiary?->meta['bank_account_name'],
                    'second_beneficiary_bank_code' => @$secondBeneficiary?->meta['bank_code'] ?? null,
                    'second_beneficiary_bank_code_type' => @$secondBeneficiary?->meta['bank_code_type'],
                    'second_beneficiary_bank_account_number' => @$secondBeneficiary?->meta['bank_account_number'],
                    'second_beneficiary_bank_iban' => @$secondBeneficiary?->meta['iban_number'] ?? null,
                    'second_beneficiary_bank_aba' => @$secondBeneficiary?->meta['aba_number'] ?? null,
                    'second_beneficiary_bank_bsb' => @$secondBeneficiary?->meta['bsb_number'] ?? null,
                    'second_beneficiary_bank_bic' => @$secondBeneficiary?->meta['bic_number'] ?? null,
                    'second_beneficiary_bank_cnaps' => @$secondBeneficiary?->meta['cnaps_number'],
                    'second_beneficiary_bank_ach_routing_number' => @$secondBeneficiary?->meta['ach_routing_number'] ?? null,
                    'reason' =>  $transferDetails['transfer_reason'],
                    'transaction_type' => 'money_transfer',
                    'delivery_method'=>'Total_Processing'
                ],
                'archived' => 0,
            ]);

            $transferDetails['transaction'] = $transaction;
            session(['money_transfer_request' => $transferDetails]);

            return redirect()->route('dashboard.international-transfer.money-transfer.total-processing', ['filter' => ['workspace_id' => $transferDetails['workspace_id']]]);
        } else if ($transferDetails['payment_method'] == PaymentMethod::BANK_ACCOUNT) {

            $masterAccountDetails = collect(Setting::getValue('money_transfer_master_account_details', []))->firstWhere('country', 231);

            if (!is_null(PartnerFoundation::getBankingPayment($request)) && PartnerFoundation::getBankingPayment($request) == true) {
                $wrappexService =  new \Kanexy\Banking\Services\WrappexService();
                $payoutService = new \Kanexy\Banking\Services\PayoutService($wrappexService);


                $account = Account::forHolder($workspace)->first();

                /** @var Contact $beneficiary */
                $beneficiary = Contact::findOrFail($masterAccountDetails['beneficiary_id']);

                /** @var Account $senderAccount */
                $senderAccount = Account::findOrFail($account->id);

                $info = [
                    'sender_account_id' => $account->id,
                    'beneficiary_id' => $beneficiary->id,
                    'amount' => $transferDetails['amount']
                ];


                $transaction = $payoutService->initialize($senderAccount, $beneficiary, $info);

                $metaDetails = [
                    'second_beneficiary_id' => $secondBeneficiary?->id,
                    'second_beneficiary_name' => @$secondBeneficiary?->meta['bank_account_name'],
                    'second_beneficiary_bank_code' => @$secondBeneficiary?->meta['bank_code'] ?? null,
                    'second_beneficiary_bank_code_type' => @$secondBeneficiary?->meta['bank_code_type'],
                    'second_beneficiary_bank_account_number' => @$secondBeneficiary?->meta['bank_account_number'],
                    'second_beneficiary_bank_iban' => @$secondBeneficiary?->meta['iban_number'] ?? null,
                    'second_beneficiary_bank_aba' => @$secondBeneficiary?->meta['aba_number'] ?? null,
                    'second_beneficiary_bank_bsb' => @$secondBeneficiary?->meta['bsb_number'] ?? null,
                    'second_beneficiary_bank_bic' => @$secondBeneficiary?->meta['bic_number'] ?? null,
                    'second_beneficiary_bank_cnaps' => @$secondBeneficiary?->meta['cnaps_number'],
                    'second_beneficiary_bank_ach_routing_number' => @$secondBeneficiary?->meta['ach_routing_number'] ?? null,
                    'exchange_rate' => $transferDetails['guaranteed_rate'],
                    'base_currency' => $sender['currency'],
                    'exchange_currency' => $receiver['currency'],
                    'recipient_amount' => $transferDetails['recipient_amount'],
                    'reason' => $transferDetails['transfer_reason'],
                    'transaction_type' => 'money_transfer',
                    'delivery_method'=>'Bank'
                ];

                $meta = array_merge($transaction->meta, $metaDetails);
                $transaction->transaction_fee = $transferDetails['fee_charge'];
                $transaction->meta = $meta;
                $transaction->update();

                $transferDetails['transaction'] = $transaction;
                session(['money_transfer_request' => $transferDetails]);

                $transactionOtpService = Setting::getValue('transaction_otp_service');

                if($transactionOtpService == 'email')
                {
                    if (config('services.disable_email_service') == false) {
                        $transaction->notify(new EmailOneTimePasswordNotification($transaction->generateOtp("email")));
                    }else
                    {
                        $transaction->generateOtp("email");
                    }
                }else
                {
                    if (config('services.disable_sms_service') == false) {
                        $transaction->notify(new SmsOneTimePasswordNotification($transaction->generateOtp("sms")));
                    }else
                    {
                        $transaction->generateOtp("sms");
                    }
                }

                return $transaction->redirectForVerification(URL::temporarySignedRoute('dashboard.international-transfer.money-transfer.verify', now()->addMinutes(30), ["id" => $transaction->id]), $transactionOtpService);
            }
        }

        $workspace = Workspace::findOrFail(session()->get('money_transfer_request.workspace_id'));
        session(['transaction_id' => $transferDetails['transaction']->id]);
        session()->forget('money_transfer_request');

        return redirect()->route('dashboard.international-transfer.money-transfer.showFinal', ['filter' => ['workspace_id' => $workspace->id]]);
    }

    public function verify(Request $request)
    {
        if (!is_null(PartnerFoundation::getBankingPayment($request)) && PartnerFoundation::getBankingPayment($request) == true) {
            $wrappexService =  new \Kanexy\Banking\Services\WrappexService();
            $payoutService = new \Kanexy\Banking\Services\PayoutService($wrappexService);
            $transaction = Transaction::find($request->query('id'));

            try {
                $payoutService->process($transaction);
            } catch (\Exception $exception) {
                if ($exception->getCode() === 500) {
                    return redirect()->route("dashboard.international-transfer.money-transfer.preview", ["workspace_id" => $transaction->workspace_id])->with([
                        'message' => 'Something went wrong. Please try again later.',
                        'status' => 'failed',
                    ]);
                }

                throw $exception;
            }

            session(['transaction_id' => $request->query('id')]);
            session()->forget('money_transfer_request');

            return redirect()->route('dashboard.international-transfer.money-transfer.showFinal', ['filter' => ['workspace_id' => $transaction->workspace_id]])->with([
                'message' => 'Processing the payment. It may take a while.',
                'status' => 'success',
            ]);
        }
    }

    public function stripe()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);
        if (is_null(session('money_transfer_request'))) {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]);
        }

        $details = session('money_transfer_request.transaction');

        return view('international-transfer::money-transfer.process.stripe', compact('details'));
    }

    public function stripeInitialize(Request $request)
    {
        $transferDetails = session('money_transfer_request.transaction');
        $stripe =  Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $data = Stripe\Charge::create([
            "amount" => $request->input('amount') * 100,
            "currency" => $transferDetails->settled_currency,
            "source" => $request->input('stripeToken'),
            "description" => session('money_transfer_request.transfer_reason') ? session('money_transfer_request.transfer_reason') : null,
        ]);

        return response()->json(['status' => 'success', 'data' => $data]);
    }


    public function storeStripePaymentDetails(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        $transferDetails = session('money_transfer_request.transaction');
        $response = $request->all();

        if ($response['data']['status'] == 'succeeded') {
            $stripeDetails = [
                'sender_payment_id' => $response['data']['id'],
                'sender_card_name' => $response['data']['source']['name'],
                'sender_card_id' => $response['data']['payment_method'],
                'sender_card_fingerprint' => $response['data']['source']['fingerprint'],
                'stripe_balance_transaction' => $response['data']['balance_transaction'],
                'stripe_receipt_url' => $response['data']['receipt_url'],
            ];

            $meta = array_merge($transferDetails?->meta, $stripeDetails);
            $transferDetails->meta = $meta;
            $transferDetails->status = 'accepted';
            $transferDetails->update();
        }
        session(['transaction_id' => $transferDetails->id]);
        session()->forget('money_transfer_request');

        return response()->json(['status' => 'success']);
    }

    public function showFinalizeTransfer()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);
        $transaction = Transaction::find(session('transaction_id'));
         /** @var \App\Models\User $user */
        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $skipKycStatus = WorkspaceMeta::where(['workspace_id' => $workspace->id, 'key' => 'skip_kyc'])->first();

        $limit = Setting::getValue('transaction_threshold_amount', []);

        if ($transaction->amount >=  $limit) {

            // if($skipKycStatus?->value == 'true')
            // {
            //         $transaction->status = 'pending-kyc';
            //         $transaction->update();

            // }
            // else
            // {
                $transaction->update(['status' => TransactionStatus::PENDING]);
            //}
            $metaDetails = [
                'transaction_id' => $transaction->urn,
                'threshold_exceeded' => true,
                'transaction_amount' => $transaction->amount,
                'alert_status' => false,
            ];
            $meta = array_merge($transaction?->meta, $metaDetails);
            $log = new Log();
            $log->id = Str::uuid();
            $log->text = $transaction->urn;
            $log->user_id = auth()->user()->id;
            $log->meta = $meta;
            $log->target()->associate($transaction);
            $log->save();

            $admin = User::whereHas("roles", function ($q) {
                $q->where("name", "super_admin");
            })->get();
            Notification::sendNow($admin, new ThresholdExceededNotification($transaction));
        }
        if($skipKycStatus?->value == 'true')
        {
                $transaction->status = 'pending-kyc';
                $transaction->update();

        }
        //$user = Auth::user();
        if (config('services.risk_management') == true) {
            if (!App::environment('local')) {
                $country = Country::findOrFail($user->country_id);
                $iplogdata = IPlogs::where('holder_id', $user->id)->first();

                if ($country->name !== $iplogdata?->ip_country) {
                    $meta = [
                        'login_country' => $iplogdata?->ip_country,
                        'residence_country' => $country->name,
                    ];

                    $iplogdata = Log::updateOrCreate(
                        [
                            'target_type' => $transaction?->getMorphClass(),
                            'target_id' =>  $transaction?->getKey(),
                            'text' => 'ip_address_transaction',
                        ],
                        [
                            'target_type' => $transaction->getMorphClass(),
                            'target_id' =>  $transaction->getKey(),
                            'id' => rand(11111, 99999),
                            'text' => 'ip_address_transaction',
                            'user_id' => auth()->user()->id,
                            'meta' => $meta,
                        ]
                    );
                }
            }
        }

        $user->notify(new RiskAssessmentNotification($user));

        $user->notify(new MoneyTransferRequestNotification($user,$workspace,$transaction));

        return view('international-transfer::money-transfer.process.final', compact('transaction'));
    }


    public function cancel(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update(['status' => TransactionStatus::CANCELLED]);
        $transferDetails = session('money_transfer_request');

        return redirect()->route('dashboard.international-transfer.money-transfer.index', ['filter' => ['workspace_id' => $transferDetails['workspace_id']]])->with([
            'status' => 'success',
            'message' => 'The money transfer request cancelled successfully.',
        ]);
    }

    public function transferCompleted(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update(['status' => TransactionStatus::COMPLETED]);

        Mail::to(auth()->user()->email)
        ->queue(new InternationalTransferDebitAlertEmail(auth()->user()->email, $transaction));

        return redirect()->route('dashboard.international-transfer.money-transfer.index')->with([
            'status' => 'success',
            'message' => 'The money transfer request completed successfully.',
        ]);
    }

    public function transferAccepted(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update(['status' => TransactionStatus::ACCEPTED]);

        $limit = Setting::getValue('transaction_threshold_amount', []);

        if ($transaction?->amount >=  $limit) {
            $logs = Log::where('meta->transaction_id', '=', $transaction?->urn)->first();
            $status = [
                'transaction_id' => $transaction?->urn,
                'transaction_amount' => $transaction?->amount,
                'threshold_exceeded' => true,
                'alert_status' => true,
            ];
            $meta = array_merge($transaction?->meta, $status);
            if (!is_null($meta) && !is_null($logs)) {
                $logs->meta = $meta;
                $logs->update();
            }
        }
        return redirect()->route('dashboard.international-transfer.money-transfer.index')->with([
            'status' => 'success',
            'message' => 'The money transfer request completed successfully.',
        ]);
    }

    public function transferPending(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update(['status' => TransactionStatus::PENDING]);

        return redirect()->route('dashboard.international-transfer.money-transfer.index')->with([
            'status' => 'success',
            'message' => 'The money transfer request pending successfully.',
        ]);
    }

    public function logDetails(Request $request, Transaction $transaction)
    {
        $log = new Log();
        $log->id = Str::uuid();
        $log->text = $request->input('text');
        $log->user_id = auth()->user()->id;
        $log->target()->associate($transaction);
        $log->save();
        return redirect()->back()->with(['status' => 'success', 'message' => 'Log Successfully']);
    }

    public function moneyTransferPDF(Request $request)
    {
        $user = Auth::user();
        $transaction = Transaction::find($request->transaction_id);
        if (!is_null(PartnerFoundation::getBankingPayment($request))) {
            $account = auth()->user()->workspaces()->first()?->accounts()->first();
        }else
        {
            $account = auth()->user()->workspaces()->first();
        }

        $view = PDF::loadView('international-transfer::money-transfer.moneytransferpdf', compact('account', 'transaction', 'user'))
            ->setPaper(array(0, 0, 1000, 900), 'landscape')
            ->output();

        return response()->streamDownload(fn () => print($view), "moneytransfer.pdf");
    }


    /**
     * totalProcessingRequest
     *
     * @return void
     */


    public function totalProcessingRequest(Request $request, TotalProcessingService $service)
    {

        $transferDetails = session('money_transfer_request.transaction');

        $data = ([
            "receiver_currency" => session('money_transfer_request.transaction.settled_currency') ? session('money_transfer_request.transaction.settled_currency') : null,
            "receiver_amount" => session('money_transfer_request.transaction.settled_amount') ? session('money_transfer_request.transaction.settled_amount') : null
        ]);


        $prepareCheckout = $service->prepare($data);
        $getData = get_object_vars($prepareCheckout);
        $checkoutId = $getData['id'];

        $getStatus = $service->getPaymentStatus($checkoutId);

        session(['checkoutId' => $checkoutId, 'transaction_id' => $transferDetails->id]);

        $base_url = config('totalprocessing.base_url');
        $url = $base_url . 'paymentWidgets.js?checkoutId=' . $checkoutId;
        return view('international-transfer::money-transfer.process.total-processing', compact('data', 'transferDetails', 'url'));
    }

    public function storeTotalProcessingDetails(TotalProcessingService $service, Request $request)
    {
        $transferDetails = session('money_transfer_request.transaction');
        $checkoutId = session('checkoutId');
        $user = Auth::user();
        $response = $service->getPaymentStatus($checkoutId);
        $data = [
            'checkoutId' => $checkoutId,
            'result' => $response->result,
            'card' => $response->card,
        ];

        if ($response->result->code !== '000.000.000') {

            $description = $response->result->description;
            $meta = array_merge($transferDetails?->meta, $data);
            $transferDetails->meta = $meta;
            $transferDetails->status = TransactionStatus::PENDING;
            $transferDetails->update();

            return back()->with(['message' => "$description", 'status' => 'failed']);
        }

        $meta = array_merge($transferDetails?->meta, $data);
        $transferDetails->meta = $meta;
        $transferDetails->status = TransactionStatus::ACCEPTED;
        $transferDetails->update();

        $riskDetails = Setting::getValue('risk_assessment',[]);
        $limit = @$riskDetails['profile_risk_threshold'] ? @$riskDetails['profile_risk_threshold'] : 0;
        $additional_info = UserMeta::where(['key' =>'risk_mgt_additional_info','user_id' => $user->id])->first();
        $totalTransaction = Transaction::select(DB::raw('SUM(amount) AS totalAmount'))->where(['workspace_id' => $transferDetails->workspace_id,'ref_type' => 'money_transfer'])->first();

        if($totalTransaction->totalAmount > $limit && is_null($additional_info))
        {
            $transferDetails->status = 'pending-review';
            $transferDetails->update();
            $user->notify(new RiskAssessmentNotification($user));
        }

        if(!is_null(@$data['source_of_fund']))
        {
            $transferDetails['source_of_fund'] = @$data['source_of_fund'];
        }


        session(['transaction_id' => $transferDetails->id]);
        session()->forget('money_transfer_request');

        return redirect()->route('dashboard.international-transfer.money-transfer.showFinal', ['filter' => ['workspace_id' => $transferDetails['workspace_id']]]);
    }

    public function adminApproval($transaction_id)
    {
        $transaction = Transaction::where('urn', $transaction_id)->first();
        $logs = Log::where('meta->transaction_id', $transaction_id)->first();
        $user = User::find($transaction->ref_id);
        $masterAccount = collect(Setting::getValue('money_transfer_master_account_details', []))->firstWhere('country', 231);
        $totalTransactionCompletedAmount = Transaction::where('workspace_id', $transaction->workspace_id)->where('status', 'completed')->selectRaw("SUM(amount) as total_amount")->first();
        $totalTransactionBeneficaryAmount = Transaction::where('meta->second_beneficiary_bank_account_number', $transaction->meta['second_beneficiary_bank_account_number'])->selectRaw("SUM(amount) as total_amount")->first();

        return view('international-transfer::money-transfer.admin-approval', compact("transaction", "user", "masterAccount", "totalTransactionCompletedAmount", "totalTransactionBeneficaryAmount"));
    }

    public function transferDeclined(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update(['status' => TransactionStatus::DECLINED]);

        $limit = Setting::getValue('transaction_threshold_amount', []);

        if ($transaction?->amount >=  $limit) {
            $logs = Log::where('meta->transaction_id', '=', $transaction?->urn)->first();
            $status = [
                'transaction_id' => $transaction?->urn,
                'transaction_amount' => $transaction?->amount,
                'threshold_exceeded' => true,
                'alert_status' => true,
            ];

            $meta = array_merge($transaction?->meta, $status);
            if (!is_null($meta) && !is_null($logs)) {
                $logs->meta = $meta;
                $logs->update();
            }
        }

        return redirect()->route('dashboard.international-transfer.money-transfer.index')->with([
            'status' => 'success',
            'message' => 'The money transfer request declined .',
        ]);
    }

    public function archivedTransactions(Request $request)
    {
        $user = Auth::user();
        $workspace = null;

        if ($request->has('filter.workspace_id')) {
            $workspace = Workspace::findOrFail($request->input('filter.workspace_id'));
        }

        return view('international-transfer::money-transfer.archived-transactions', compact('user','workspace'));
    }

    public function ccPayout(Request $request,CurrencyCloudService $ccService)
    {
        $data['transaction'] = Transaction::find($request->payment)->toArray();
        $beneficiaryid = $data['transaction']['meta']['beneficiary_id'];
        $data['beneficairy'] = Contact::find($beneficiaryid)->toArray();
        $workspace = Workspace::find( $data['transaction']['workspace_id']);
        $user = $workspace->users()->first();
        $data['kyc'] = UserSetting::whereUserId($user->id)->first();
        $data['user'] = $user;
        
        $response = $ccService->payout($data);
        if($response['code'] = 200)
        {
            return redirect()->route('dashboard.international-transfer.money-transfer.index')->with(['status' => 'success', 'message' => $response['msg']]);
        }else
        {
            return redirect()->route('dashboard.international-transfer.money-transfer.index')->with(['status' => 'failed', 'message' => $response['msg']]);
        }
    }
}
