<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Notifications\SmsOneTimePasswordNotification;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\MoneyTransfer;
use Kanexy\InternationalTransfer\Enums\PaymentMethod;
use Kanexy\InternationalTransfer\Http\Requests\MoneyTransferRequest;
use Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy;
use Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus;
use Kanexy\PartnerFoundation\Banking\Models\Account;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Kanexy\PartnerFoundation\Banking\Services\PayoutService;
use Kanexy\PartnerFoundation\Core\Models\Log;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Stripe;

class MoneyTransferController extends Controller
{
    private PayoutService $payoutService;

    public function __construct(PayoutService $payoutService)
    {
        $this->payoutService = $payoutService;
    }

    public function index(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::VIEW, MoneyTransfer::class);

        session()->forget('transaction_id');

        $transactions = QueryBuilder::for(Transaction::class)
        ->allowedFilters([
            AllowedFilter::exact('workspace_id'),
        ]);

        $workspace = null;

        if ($request->has('filter.workspace_id')) {
            $workspace = Workspace::findOrFail($request->input('filter.workspace_id'));
        }

        $transactions = $transactions->where("meta->transaction_type", 'money_transfer')->latest()->paginate();

        return view('international-transfer::money-transfer.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);
        session()->forget('transaction_id');

        $workspace = Workspace::findOrFail($request->input('filter.workspace_id'));
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        return view('international-transfer::money-transfer.process.create', compact('countries', 'defaultCountry', 'workspace'));
    }

    public function store(MoneyTransferRequest $request)
    {
        $data = $request->validated();

        $existSessionRequest = session('money_transfer_request');

        if(!is_null(session('money_transfer_request')))
        {
            $data['beneficiary_id'] = $existSessionRequest['beneficiary_id'];
            $data['transaction'] = isset($existSessionRequest['transaction']) ? $existSessionRequest['transaction'] : null;
            $data['payment_method'] = $existSessionRequest['payment_method'];
            $data['transfer_reason'] = $existSessionRequest['transfer_reason'];
        }

        session(['money_transfer_request' => $data]);

        return redirect()->route('dashboard.international-transfer.money-transfer.beneficiary',['filter' => ['workspace_id' => $request->input('workspace_id')]]);

    }

    public function showBeneficiary()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        if(is_null(session('money_transfer_request')))
        {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]);
        }

        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $account = Account::forHolder($workspace)->first();
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $beneficiaries = Contact::beneficiaries()->verified()->forWorkspace($workspace)->whereRefType('money_transfer')->orderBy('id','desc')->take(5)->get();

        return view('international-transfer::money-transfer.process.beneficiary', compact('user', 'account', 'countries', 'defaultCountry', 'workspace', 'beneficiaries'));
    }

    public function beneficiaryStore()
    {
        $user = Auth::user();
        $workspace = $user->workspaces()->first();

        return redirect()->route('dashboard.international-transfer.money-transfer.beneficiary',['filter' => ['workspace_id' => $workspace->id]])->withErrors(['beneficiary' =>'Please create or select beneficiary']);
    }

    public function showPaymentMethod(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        if(is_null(session('money_transfer_request')))
        {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]);
        }

        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $account = Account::forHolder($workspace)->first();
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));

        $transferDetails = session('money_transfer_request');
        $sender =  $transferDetails ? Country::find($transferDetails['currency_code_from']) : null;
        $receiver = $transferDetails ? Country::find($transferDetails['currency_code_to']) : null;
        $totalAmount =  $transferDetails ? ($transferDetails['amount'] - $transferDetails['fee_charge']) : 0;
        $reasons = collect(Setting::getValue('money_transfer_reasons',[]));

        return view('international-transfer::money-transfer.process.payment', compact('user', 'account', 'countries', 'defaultCountry', 'workspace', 'sender', 'receiver', 'transferDetails', 'totalAmount', 'reasons'));
    }

    public function transactionDetail(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        if(is_null(session('money_transfer_request')))
        {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]);
        }

        $data = $request->validate([
            'transfer_reason' => ['required', 'string'],
            'payment_method'  => ['required', 'string'],
        ]);

        $transferDetails = session('money_transfer_request');
        $sender =  $transferDetails ? Country::find($transferDetails['currency_code_from']) : null;
        $receiver = $transferDetails ? Country::find($transferDetails['currency_code_to']) : null;
        $user = Auth::user();
        $workspace = $transferDetails ? Workspace::find($transferDetails['workspace_id']) : $request->input('filter.workspace_id');
        $account = Account::forHolder($workspace)->first();
        $secondBeneficiary = $transferDetails ? Contact::find($transferDetails['beneficiary_id']) : null;

        if($data['payment_method'] == PaymentMethod::BANK_ACCOUNT)
        {
            if($transferDetails['amount'] > $account->balance)
            {
                return redirect()->route('dashboard.international-transfer.money-transfer.payment',['filter' => ['workspace_id' => $transferDetails['workspace_id']]])->withErrors(
                    ['payment_method' => 'Insufficient account balance.']
                );
            }
        }

        if($data['payment_method'] == PaymentMethod::MANUAL_TRANSFER)
        {
            $transactionExist = isset($transferDetails['transaction']) ?  $transferDetails['transaction'] : null;
            $transaction = Transaction::updateOrCreate([
                'id' => $transactionExist?->id,
            ],[
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
                'meta' => [
                    'reference_no' => MoneyTransfer::generateUrn(),
                    'sender_id' => $account->id,
                    'sender_name' => $account->name,
                    'beneficiary_id' => $transferDetails['beneficiary_id'],
                    'exchange_rate' => $transferDetails['guaranteed_rate'],
                    'base_currency' => $sender['currency'],
                    'exchange_currency' => $receiver['currency'],
                    'recipient_amount' => $transferDetails['recipient_amount'],
                    'second_beneficiary_name' => $secondBeneficiary?->meta['bank_account_name'],
                    'second_beneficiary_bank_code' => $secondBeneficiary?->meta['bank_code'] ?? null,
                    'second_beneficiary_bank_code_type' => $secondBeneficiary?->meta['bank_code_type'],
                    'second_beneficiary_bank_account_number' => $secondBeneficiary?->meta['bank_account_number'],
                    'second_beneficiary_bank_iban' => $secondBeneficiary?->meta['iban_number'],
                    'reason' =>  $data['transfer_reason'],
                    'transaction_type' => 'money_transfer',
                ],
            ]);
            $transferDetails['transaction'] = $transaction;
        }

        $transferDetails['payment_method'] = $data['payment_method'];
        $transferDetails['transfer_reason'] = $data['transfer_reason'];
        session(['money_transfer_request' => $transferDetails]);

        return redirect()->route('dashboard.international-transfer.money-transfer.preview',['filter' => ['workspace_id' => $transferDetails['workspace_id']]]);
    }

    public function preview()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        if(is_null(session('money_transfer_request')))
        {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]);
        }

        $user = Auth::user();
        $transferDetails = session('money_transfer_request');
        $sender =  $transferDetails ? Country::find($transferDetails['currency_code_from']) : null;
        $receiver = $transferDetails ? Country::find($transferDetails['currency_code_to']) : null;
        $secondBeneficiary = $transferDetails ? Contact::find($transferDetails['beneficiary_id']) : null;
        $beneficiary = null;
        $transaction = null;
        $transferReason = null;
        if(isset($transferDetails['transaction']))
        {
            $beneficiary = Contact::find($transferDetails['transaction']->meta['beneficiary_id']);
            $transaction = $transferDetails['transaction'];
        }
        $masterAccount =  collect(Setting::getValue('money_transfer_master_account_details',[]));
        $workspace = Workspace::findOrFail(session()->get('money_transfer_request.workspace_id'));
        $transferReason = collect(Setting::getValue('money_transfer_reasons',[]))->firstWhere('id', $transferDetails['transfer_reason']);

        return view('international-transfer::money-transfer.process.preview', compact('user', 'transferDetails', 'beneficiary', 'masterAccount', 'workspace', 'transaction', 'transferReason','secondBeneficiary','sender','receiver'));
    }

    public function finalizeTransfer(Request $request)
    {
        if(is_null(session('money_transfer_request')))
        {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]);
        }

        $transferDetails = session('money_transfer_request');
        $user = Auth::user();
        $sender =  $transferDetails ? Country::find($transferDetails['currency_code_from']) : null;
        $receiver = $transferDetails ? Country::find($transferDetails['currency_code_to']) : null;
        $secondBeneficiary = $transferDetails ? Contact::find($transferDetails['beneficiary_id']) : null;
        $workspace = $transferDetails ? Workspace::find($transferDetails['workspace_id']) : $request->input('filter.workspace_id');
        $account = Account::forHolder($workspace)->first();

        if($transferDetails['payment_method'] == PaymentMethod::STRIPE)
        {
            $transactionExist = isset($transferDetails['transaction']) ?  $transferDetails['transaction'] : null;
            $transaction = Transaction::updateOrCreate([
                'id' => $transactionExist?->id,
            ],[
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
                'meta' => [
                    'reference_no' => MoneyTransfer::generateUrn(),
                    'sender_id' => $account->id,
                    'sender_name' => $account->name,
                    'beneficiary_id' => $transferDetails['beneficiary_id'],
                    'exchange_rate' => $transferDetails['guaranteed_rate'],
                    'base_currency' => $sender['currency'],
                    'exchange_currency' => $receiver['currency'],
                    'recipient_amount' => $transferDetails['recipient_amount'],
                    'second_beneficiary_name' => $secondBeneficiary?->meta['bank_account_name'],
                    'second_beneficiary_bank_code' => $secondBeneficiary?->meta['bank_code'] ?? null,
                    'second_beneficiary_bank_code_type' => $secondBeneficiary?->meta['bank_code_type'],
                    'second_beneficiary_bank_account_number' => $secondBeneficiary?->meta['bank_account_number'],
                    'second_beneficiary_bank_iban' => $secondBeneficiary?->meta['iban_number'],
                    'reason' =>  $transferDetails['transfer_reason'],
                    'transaction_type' => 'money_transfer',
                ],
            ]);

            $transferDetails['transaction'] = $transaction;
            session(['money_transfer_request' => $transferDetails]);

            return redirect()->route('dashboard.international-transfer.money-transfer.stripe',['filter' => ['workspace_id' => $transferDetails['workspace_id']]]);

        }else if($transferDetails['payment_method'] == PaymentMethod::BANK_ACCOUNT){
            $masterAccountDetails = Setting::getValue('money_transfer_master_account_details');

            /** @var Contact $beneficiary */
            $beneficiary = Contact::findOrFail($masterAccountDetails['beneficiary_id']);

            /** @var Account $senderAccount */
            $senderAccount = Account::findOrFail($account->id);

            $info = [
                'sender_account_id' => $account->id,
                'beneficiary_id'    => $beneficiary->id,
                'amount'            => $transferDetails['amount']
            ];

            $transaction = $this->payoutService->initialize($senderAccount, $beneficiary, $info);

            $metaDetails = [
                'second_beneficiary_id' => $secondBeneficiary?->id,
                'second_beneficiary_name' => $secondBeneficiary?->meta['bank_account_name'],
                'second_beneficiary_bank_code' => $secondBeneficiary?->meta['bank_code'] ?? null,
                'second_beneficiary_bank_code_type' => $secondBeneficiary?->meta['bank_code_type'],
                'second_beneficiary_bank_account_number' => $secondBeneficiary?->meta['bank_account_number'],
                'second_beneficiary_bank_iban' => $secondBeneficiary?->meta['iban_number'],
                'exchange_rate' => $transferDetails['guaranteed_rate'],
                'base_currency' => $sender['currency'],
                'exchange_currency' => $receiver['currency'],
                'recipient_amount' => $transferDetails['recipient_amount'],
                'reason' =>  $transferDetails['transfer_reason'],
                'transaction_type' => 'money_transfer',
            ];

            $meta = array_merge($transaction->meta,$metaDetails);
            $transaction->transaction_fee = $transferDetails['fee_charge'];
            $transaction->meta = $meta;
            $transaction->update();

            $transferDetails['transaction'] = $transaction;
            session(['money_transfer_request' => $transferDetails]);

            $transaction->notify(new SmsOneTimePasswordNotification($transaction->generateOtp("sms")));
            // $transaction->generateOtp("sms");

            return $transaction->redirectForVerification(URL::temporarySignedRoute('dashboard.international-transfer.money-transfer.verify', now()->addMinutes(30),["id"=>$transaction->id]), 'sms');
        }

        $workspace = Workspace::findOrFail(session()->get('money_transfer_request.workspace_id'));
        session(['transaction_id' => $transferDetails['transaction']->id]);
        session()->forget('money_transfer_request');

        return redirect()->route('dashboard.international-transfer.money-transfer.showFinal',['filter' => ['workspace_id' => $workspace->id]]);
    }

    public function verify(Request $request)
    {
        $transaction=Transaction::find($request->query('id'));

        try {
            $this->payoutService->process($transaction);
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

        return redirect()->route('dashboard.international-transfer.money-transfer.showFinal',['filter' => ['workspace_id' => $transaction->workspace_id]])->with([
            'message' => 'Processing the payment. It may take a while.',
            'status' => 'success',
        ]);
    }

    public function stripe()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);
        if(is_null(session('money_transfer_request')))
        {
            return redirect()->route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]);
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

        return response()->json(['status' => 'success','data' => $data]);
    }


    public function storeStripePaymentDetails(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        $transferDetails = session('money_transfer_request.transaction');
        $response = $request->all();


        if($response['data']['status'] == 'succeeded')
        {
            $stripeDetails = [
                'sender_payment_id' => $response['data']['id'],
                'sender_card_name' => $response['data']['source']['name'],
                'sender_card_id' => $response['data']['payment_method'],
                'sender_card_fingerprint' => $response['data']['source']['fingerprint'],
                'stripe_balance_transaction' => $response['data']['balance_transaction'],
                'stripe_receipt_url' => $response['data']['receipt_url'],
            ];

            $meta = array_merge($transferDetails->meta,$stripeDetails);
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

        return view('international-transfer::money-transfer.process.final', compact('transaction'));
    }


    public function cancel(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update(['status' => TransactionStatus::CANCELLED]);
        $transferDetails = session('money_transfer_request');

        return redirect()->route('dashboard.international-transfer.money-transfer.index',['filter' => ['workspace_id' => $transferDetails['workspace_id']]])->with([
            'status' => 'success',
            'message' => 'The money transfer request cancelled successfully.',
        ]);
    }

    public function transferCompleted(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update(['status' => TransactionStatus::COMPLETED]);

        return redirect()->route('dashboard.international-transfer.money-transfer.index')->with([
            'status' => 'success',
            'message' => 'The money transfer request completed successfully.',
        ]);
    }

    public function transferAccepted(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update(['status' => TransactionStatus::ACCEPTED]);

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

}
