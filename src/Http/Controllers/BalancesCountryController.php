<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;


use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BalancesCountryController extends Controller
{
    public function index()
    {
        $countries = Country::get();
        $balance_country = Setting::getValue('international-transfer_balance_country',[]);

        return view("international-transfer::configuration.balances-country.index",compact('countries','balance_country'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'balance_country' => 'required|array',
        ]);

        Setting::updateOrCreate(
            ['key' => 'international-transfer_balance_country'],
            ['value' => $data['balance_country']]
        );

        return redirect()->route('dashboard.international-transfer.balances-country.index')
            ->with([
                'status' => 'success',
                'message' => 'Balancing Countries are updated successfully.',
            ]);
    }

}
