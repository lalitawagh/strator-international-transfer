<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Http\Request;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Http\Requests\StoreRiskManagementRequest;

class RiskManagementController extends Controller
{
    public function createRiskManagement()
    {
        $highriskcountry = Setting::getValue("high_risk_country");
        $lowriskcountry = Setting::getValue("low_risk_country");
        $countries = Country::orderBy("name")->pluck("name", "id");
        $riskscores = Setting::getValue('risk_scores');
        return view("international-transfer::configuration.risk-management.create", compact('countries','highriskcountry','lowriskcountry','riskscores'));
    }

    public function storeRiskCountry(StoreRiskManagementRequest $request)
    {
        $data = $request->validate([
            'high_risk_score'  => ['required', 'numeric'],
            'medium_risk_score'  => ['required', 'numeric'],
            'low_risk_score'  => ['required', 'numeric'],
        ]);

        Setting::updateOrCreate(['key' => 'risk_scores'], ['key' => 'risk_scores', 'value' => $data]);

        Setting::updateOrCreate(['key' => 'high_risk_country'], ['key' => 'high_risk_country', 'value' => $request->input("high_risk_country")]);
        Setting::updateOrCreate(['key' => 'low_risk_country'], ['key' => 'low_risk_country', 'value' => $request->input("low_risk_country")]);
        return redirect()->route('dashboard.international-transfer.riskManagement')->with([
            'status' => 'success',
            'message' => 'The Risk Management Configuration Added Successfully.',
        ]);
    }
}
