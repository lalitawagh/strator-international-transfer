<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Http\Request;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Http\Requests\StoreCountryRequest;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::get();

        return view("international-transfer::configuration.country.index",compact('countries'));
    }

    public function store(StoreCountryRequest $request)
    {
        $data = $request->validated();
        $data['id'] = now()->format('dmYHis');
        $settings = collect(Setting::getValue('international-transfer_country_currency',[]))->push($data);
        Setting::updateOrCreate(['key' => 'international-transfer_country_currency'], ['value' => $settings]);

        return redirect()->route('dashboard.international-transfer.country.index')->with([
            'status' => 'success',
            'message' => 'Country Currency updated successfully.',
        ]);
    }

}
