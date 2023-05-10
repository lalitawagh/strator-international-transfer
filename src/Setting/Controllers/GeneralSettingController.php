<?php

namespace Kanexy\InternationalTransfer\Setting\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Kanexy\Cms\Enums\WordpressPages;
use Kanexy\Cms\Setting\Models\Setting;

class GeneralSettingController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'rate_type' => 'nullable',
            'customized_rate' => 'nullable|numeric',
            'percentage_rate' => 'nullable',
            'percentage' => 'nullable|numeric'
        ]);
        dd($data);
        Setting::updateOrCreate(['key' => 'gdpr_request'], ['value' => $data]);
        //session(['tab' => 'gdprsetting']);

        return redirect()->route("dashboard.settings.index")->with([
            'status' => 'success', 'message' => 'GDPR Settings updated successfully.'
        ]);
    }
}
