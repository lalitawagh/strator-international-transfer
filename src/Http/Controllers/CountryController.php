<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Http\Requests\StoreCountryRequest;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::get();
        $sendingCurrency = Setting::getValue('international-transfer_sending_currency',[]);
        $receivingCurrency = Setting::getValue('international-transfer_receiving_currency', []);

        return view("international-transfer::configuration.country.index",compact('countries','sendingCurrency','receivingCurrency'));
    }

    public function store(StoreCountryRequest $request)
    {
        $data = $request->validated();

        Setting::updateOrCreate(['key' => 'international-transfer_sending_currency'], ['value' => $data['sending_currency']]);
        Setting::updateOrCreate(['key' => 'international-transfer_receiving_currency'], ['value' => $data['receiving_currency']]);

        return redirect()->route('dashboard.international-transfer.country.index')->with([
            'status' => 'success',
            'message' => 'Countries Currency is updated successfully.',
        ]);
    }

}
