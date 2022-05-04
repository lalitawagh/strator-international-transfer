<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\MoneyTransfer;
use Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy;
use Kanexy\PartnerFoundation\Banking\Models\Account;
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

        return view('international-transfer::money-transfer.process.payment', compact('user', 'account', 'countries', 'defaultCountry', 'workspace'));
    }
}
