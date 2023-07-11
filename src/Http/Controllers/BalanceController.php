<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Kanexy\Cms\Enums\Role as EnumsRole;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\Role;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Models\CcCurrencyConversion;

class BalanceController extends Controller
{
    public function create()
    {
        return view("international-transfer::balance.balance");
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $workspace = $user->workspaces()->first();

        $currencyData = CcCurrencyConversion::where('holder_id', $workspace->id)->get();
        //dd($currencyData->toArray());
        //$array = $currencyData->toArray();
        //dd($array);

        // $countryFlag = Country::where('currency',$array['id'])->get();
        // dd($countryFlag);

        return view("international-transfer::balances.index", compact('currencyData'));
    }

    public function addBalance()
    {
        return view("international-transfer::balances.add-currency");
    }

    public function currencyDetails($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $workspace = $user->workspaces()->first();

        $currencyDetails = CcCurrencyConversion::where('id', $id)->first();
        //dd($currencyDetails);

        return view("international-transfer::balances.currency-details",compact('currencyDetails'));
    }

}
