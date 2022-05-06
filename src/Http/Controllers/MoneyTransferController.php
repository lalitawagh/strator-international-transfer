<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\MoneyTransfer;
use Kanexy\InternationalTransfer\Enums\PaymentMethod;
use Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy;
use Kanexy\PartnerFoundation\Banking\Models\Account;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Helper;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;

class MoneyTransferController extends Controller
{
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
        $beneficiaries = Contact::beneficiaries()->verified()->forWorkspace($workspace)->whereRefType('money_transfer')->latest()->take(5)->get();

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
        $sender = Country::find($transferDetails['currency_code_from']);
        $receiver = Country::find($transferDetails['currency_code_to']);
        $totalAmount = $transferDetails['amount'] - $transferDetails['fee_charge'];
        $reasons = collect(Setting::getValue('money_transfer_reasons',[]));

        return view('international-transfer::money-transfer.process.payment', compact('user', 'account', 'countries', 'defaultCountry', 'workspace', 'sender', 'receiver', 'transferDetails', 'totalAmount', 'reasons'));
    }

    public function transactionDetail(Request $request)
    {
        $data = $request->validate([
            'transfer_reason' => ['required', 'string'],
            'payment_method'  => ['required', 'string'],
        ]);

        $transferDetails = session('money_transfer_request');
        $sender = Country::find($transferDetails['currency_code_from']);
        $receiver = Country::find($transferDetails['currency_code_to']);
        $user = Auth::user();

        if($data['payment_method'] == PaymentMethod::MANUALLY_TRANSFER)
        {
            $transaction = Transaction::create([
                'urn' => Transaction::generateUrn(),
                'amount' => $transferDetails['amount'],
                'workspace_id' => $transferDetails['workspace_id'],
                'type' => 'debit',
                'payment_method' => PaymentMethod::MANUALLY_TRANSFER,
                'note' => null,
                'ref_id' =>  $user->id,
                'ref_type' => 'money_transfer',
                'settled_amount' => $transferDetails['amount'],
                'settled_currency' => $sender['currency'],
                'settlement_date' => date('Y-m-d'),
                'settled_at' => now(),
                'transaction_fee' => $transferDetails['fee_charge'],
                'status' => 'draft',
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
        }

        $transferDetails['transaction'] = $transaction;
        session(['money_transfer_request' => $transferDetails]);

        return redirect()->route('dashboard.international-transfer.money-transfer.preview',['filter' => ['workspace_id' => $transferDetails['workspace_id']]]);
    }

    public function preview()
    {
        $this->authorize(MoneyTransferPolicy::CREATE, MoneyTransfer::class);

        $user = Auth::user();
        $transferDetails = session('money_transfer_request');
        $beneficiary = Contact::find($transferDetails['transaction']->meta['beneficiary_id']);
        $masterAccount =  collect(Setting::getValue('money_transfer_master_account_details',[]));
        $workspace = Workspace::findOrFail(session()->get('money_transfer_request.workspace_id'));

        return view('international-transfer::money-transfer.process.preview', compact('user', 'transferDetails', 'beneficiary', 'masterAccount', 'workspace'));
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

    public function final()
    {
        $workspace = Workspace::findOrFail(session()->get('money_transfer_request.workspace_id'));
        session()->forget('card_request');

        return view('international-transfer::money-transfer.process.preview');
    }

}
