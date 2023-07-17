<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Http\Requests\StoreCcAccountSettingRequest;

class CcAccountSettingController extends Controller
{
    public function store(StoreCcAccountSettingRequest $request)
    {
        $data = $request->validated();
        $baseUrl = config('currency-cloud.cc_account_dev_url');

        if (Setting::getValue('cc_account_environment') === 'production') {
            $baseUrl = config('currency-cloud.cc_account_prod_url');
        }
     
        $result = Http::asForm()->post($baseUrl . '/oauth/token', [
            "grant_type" => "password",
            "client_id" => $data['cc_account_client_id'],
            "client_secret" => $data['cc_account_client_secret'],
            "username" => $data['cc_account_email'],
            "password" => $data['cc_account_password'],
            "scope" => "",
        ])->json('access_token');
       

        if(is_null($result))
        {
            return back()->withError('CC Account Credentials is invalid please enter valid details');

        } else {
            $data['cc_account_access_token'] = $result;
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        session(['tab' => 'cc-account-settings']);

        return redirect()->route("dashboard.settings.index")->with([
            'status' => 'success',
            'message' => 'CC Account settings updated successfully.',
        ]);
    }
}
