<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\PartnerFoundation\Banking\Models\Account;

class MoneyTransferController extends Controller
{
    public function index()
    {
        return view('international-transfer::money-transfer.index');
    }

    public function create()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        return view('international-transfer::money-transfer.process.create', compact('countries', 'defaultCountry'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'currency_code_from' => ['required', 'exists:countries,id'],
            'currency_code_to' => ['required', 'exists:countries,id'],
            'amount' => ['required'],
            'fee_charge' => ['required'],
            'guaranteed_rate' => ['required'],
            'recipient_amount' => ['required'],
        ]);

        /* Need to add policy*/

        session(['money_transfer_request' => $data]);

        return redirect()->route('dashboard.international-transfer.money-transfer.beneficiary');

    }

    public function showBeneficiary()
    {
        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $account = Account::forHolder($workspace)->first();
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));

        return view('international-transfer::money-transfer.process.beneficiary', compact('user', 'account', 'countries', 'defaultCountry', 'workspace'));
    }

    public function showPaymentMethod()
    {
        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $account = Account::forHolder($workspace)->first();
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));

        return view('international-transfer::money-transfer.process.payment', compact('user', 'account', 'countries', 'defaultCountry', 'workspace'));
    }
}
