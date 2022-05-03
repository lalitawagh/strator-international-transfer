<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;

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
}
