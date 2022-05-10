<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Notifications\SmsOneTimePasswordNotification;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\MoneyTransfer;
use Kanexy\InternationalTransfer\Enums\PaymentMethod;
use Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy;
use Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus;
use Kanexy\PartnerFoundation\Banking\Models\Account;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Kanexy\PartnerFoundation\Banking\Services\PayoutService;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Stripe;

class MoneyTransferController extends Controller
{
    private PayoutService $payoutService;

    public function __construct(PayoutService $payoutService)
    {
        $this->payoutService = $payoutService;
    }

    public function index()
    {
        $this->authorize(MoneyTransferPolicy::VIEW, MoneyTransfer::class);

        return view('international-transfer::money-transfer.index');
    }

    public function create(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        $workspace = Workspace::findOrFail($request->input('filter.workspace_id'));
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        return view('international-transfer::money-transfer.process.create', compact('countries', 'defaultCountry', 'workspace'));
    }

    public function store(Request $request)
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        $data = $request->validate([
            'currency_code_from' => ['required', 'exists:countries,id'],
            'currency_code_to' => ['required', 'exists:countries,id'],
            'amount' => ['required'],
            'fee_charge' => ['required'],
            'guaranteed_rate' => ['required'],
            'recipient_amount' => ['required'],
            'workspace_id' => ['required'],
        ]);

        session(['money_transfer_request' => $data]);

        return redirect()->route('dashboard.international-transfer.money-transfer.beneficiary',['filter' => ['workspace_id' => $request->input('workspace_id')]]);

    }

    public function showBeneficiary()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $account = Account::forHolder($workspace)->first();
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $beneficiaries = Contact::beneficiaries()->verified()->forWorkspace($workspace)->whereRefType('money_transfer')->orderBy('id','desc')->take(5)->get();

        return view('international-transfer::money-transfer.process.beneficiary', compact('user', 'account', 'countries', 'defaultCountry', 'workspace', 'beneficiaries'));
    }

    public function showPaymentMethod()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

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

        if($data['payment_method'] == PaymentMethod::MANUAL_TRANSFER || $data['payment_method'] == PaymentMethod::STRIPE)
        {
            $transaction = Transaction::create([
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
                    'sender_id' => $user->id,
                    'sender_name' => $user->getFullName(),
                    'beneficiary_id' => $transferDetails['beneficiary_id'],
                    'exchange_rate' => $transferDetails['guaranteed_rate'],
                    'base_currency' => $sender['currency'],
                    'exchange_currency' => $receiver['currency'],
                    'recipient_amount' => $transferDetails['recipient_amount'],
                ],
            ]);
        }else if($data['payment_method'] == PaymentMethod::BANK_ACCOUNT){
            $masterAccountDetails = Setting::getValue('money_transfer_master_account_details');

            /** @var Contact $beneficiary */
            $beneficiary = Contact::findOrFail($masterAccountDetails['beneficiary_id']);

            /** @var Account $sender */
            $sender = Account::findOrFail($account->id);

            $info = [
                'sender_account_id' => $account->id,
                'beneficiary_id'    => $beneficiary->id,
                'reference'         => $data['transfer_reason'],
                'amount'            => $transferDetails['amount']
            ];

            $transaction = $this->payoutService->initialize($sender, $beneficiary, $info);

            $secondaryBeneficiary = [
                'second_beneficiary_id' => $secondBeneficiary?->id,
                'second_beneficiary_name' => $secondBeneficiary?->meta['bank_account_name'],
                'second_beneficiary_bank_code' => $secondBeneficiary?->meta['bank_code'],
                'second_beneficiary_bank_code_type' => $secondBeneficiary?->meta['bank_code_type'],
                'second_beneficiary_bank_account_number' => $secondBeneficiary?->meta['bank_account_number'],
            ];

            $meta = array_merge($transaction->meta,$secondaryBeneficiary);
            $transaction->meta = $meta;
            $transaction->update();
        }

        $transferDetails['transaction'] = $transaction;
        $transferDetails['payment_method'] = $data['payment_method'];
        $transferDetails['transfer_reason'] = $data['transfer_reason'];
        session(['money_transfer_request' => $transferDetails]);

        return redirect()->route('dashboard.international-transfer.money-transfer.preview',['filter' => ['workspace_id' => $transferDetails['workspace_id']]]);
    }

    public function preview()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        $user = Auth::user();
        $transferDetails = session('money_transfer_request');
        $beneficiary = $transferDetails ? Contact::find($transferDetails['transaction']->meta['beneficiary_id']) : null;
        $masterAccount =  collect(Setting::getValue('money_transfer_master_account_details',[]));
        $workspace = Workspace::findOrFail(session()->get('money_transfer_request.workspace_id'));
        $transaction = $transferDetails['transaction'];

        return view('international-transfer::money-transfer.process.preview', compact('user', 'transferDetails', 'beneficiary', 'masterAccount', 'workspace', 'transaction'));
    }

    public function finalizeTransfer()
    {
        $transferDetails = session('money_transfer_request');

        if($transferDetails['payment_method'] == PaymentMethod::BANK_ACCOUNT)
        {
            $transaction = $transferDetails['transaction'];
            $transaction->notify(new SmsOneTimePasswordNotification($transaction->generateOtp("sms")));
            // $transaction->generateOtp("sms");

            return $transaction->redirectForVerification(URL::temporarySignedRoute('dashboard.international-transfer.money-transfer.verify', now()->addMinutes(30),["id"=>$transaction->id]), 'sms');
        }else if($transferDetails['payment_method'] == PaymentMethod::STRIPE)
        {
            return redirect()->route('dashboard.international-transfer.money-transfer.stripe',['filter' => ['workspace_id' => $transferDetails['workspace_id']]]);
        }

        $workspace = Workspace::findOrFail(session()->get('money_transfer_request.workspace_id'));
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


        return redirect()->route('dashboard.international-transfer.money-transfer.showFinal',['filter' => ['workspace_id' => $transaction->workspace_id]])->with([
            'message' => 'Processing the payment. It may take a while.',
            'status' => 'success',
        ]);
    }

    public function stripe()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

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
                'sender_name' => $response['data']['source']['name'],
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

        return response()->json(['status' => 'success']);
    }

    public function showFinalizeTransfer()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        return view('international-transfer::money-transfer.process.final');
    }


    public function cancel(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update(['status' => 'cancelled']);
        $transferDetails = session('money_transfer_request');

        return redirect()->route('dashboard.international-transfer.money-transfer.index',['filter' => ['workspace_id' => $transferDetails['workspace_id']]])->with([
            'status' => 'success',
            'message' => 'The money transfer request cancelled successfully.',
        ]);
    }

}
