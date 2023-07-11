<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Enums\Role as EnumsRole;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\Role;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\CurrencyCloud\Dtos\ConversionDetailRateDto;
use Kanexy\CurrencyCloud\Dtos\CreateConversionDto;
use Kanexy\CurrencyCloud\Dtos\RateDetailedExchangeDto;
use Kanexy\CurrencyCloud\Services\CurrencyCloudApiService;
use Kanexy\InternationalTransfer\Http\Requests\ConversionRequest;
use Kanexy\InternationalTransfer\Models\CcCurrencyConversion;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Kanexy\PartnerFoundation\Workspace\Models\WorkspaceMeta;

class ConversionController extends Controller
{

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));

        return view("international-transfer::conversion.process.create",compact('countries','defaultCountry','workspace'));
    }

    public function store(ConversionRequest $request)
    {
        $conversionData = $request->validated();
        $workspace = Workspace::findOrFail($request->input('workspace_id'));

        $conversion = Contact::updateOrCreate([
            'display_name' => $workspace['name'],
            'email' => $workspace['email'],
            'mobile' => $workspace['phone'],
            'workspace_id' => $workspace->getKey(),
            'classification' => ['cc_conversion'],
            'meta' => [
                'currency_sell' => $conversionData['currency_sell'],
                'currency_buy' => $conversionData['currency_buy'],
                'amount_to' => $conversionData['amount_to'],
                'sell' => $conversionData['sell'],
                'buy' => $conversionData['buy'],
            ],
        ]);

        $sellCurrencyCode = Country::where('id',$conversion->meta['currency_sell'])->first();
        $buyCurrencyCode = Country::where('id',$conversion->meta['currency_buy'])->first();

        $service = new CurrencyCloudApiService();
        $ccExchangeRate = $service->getConversionDetailedRate(new ConversionDetailRateDto($conversion, $sellCurrencyCode, $buyCurrencyCode));
        //dd($ccExchangeRate);
        $conversionRate =  [
                "settlement_cut_off_time" => $ccExchangeRate['settlement_cut_off_time'],
                "currency_pair" => $ccExchangeRate['currency_pair'],
                "client_buy_currency" => $ccExchangeRate['client_buy_currency'],
                "client_sell_currency" => $ccExchangeRate['client_sell_currency'],
                "client_buy_amount" => $ccExchangeRate['client_buy_amount'],
                "client_sell_amount" => $ccExchangeRate['client_sell_amount'],
                "fixed_side" => $ccExchangeRate['fixed_side'],
                "client_rate" => $ccExchangeRate['client_rate'],
                "partner_rate" => $ccExchangeRate['partner_rate'],
                "core_rate" => $ccExchangeRate['core_rate'],
                "deposit_required" => $ccExchangeRate['deposit_required'],
                "deposit_amount" => $ccExchangeRate['deposit_amount'],
                "deposit_currency" => $ccExchangeRate['deposit_currency'],
                "mid_market_rate" => $ccExchangeRate['mid_market_rate'],
        ];
        $meta = array_merge($conversion->meta, $conversionRate);
        $conversion->meta = $meta;
        $conversion->update();

        return redirect()->route('dashboard.international-transfer.conversion-preview', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]);
    }

    public function conversionPreview()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $rates = Contact::where('workspace_id',$workspace->id)->whereJsonContains('classification','cc_conversion')->latest()->first();
        //dd($rates);
        return view("international-transfer::conversion.process.preview", compact('rates','workspace'));
    }

    public function showFinalizeConversion()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $finalConversion = Contact::where('workspace_id',$workspace->id)->whereJsonContains('classification','cc_conversion')->latest()->first();
        $sellCurrencyCode = Country::where('id',$finalConversion->meta['currency_sell'])->first();
        $buyCurrencyCode = Country::where('id',$finalConversion->meta['currency_buy'])->first();
        $service = new CurrencyCloudApiService();
        $conversionInfo = $service->createConversion(new CreateConversionDto($finalConversion,$sellCurrencyCode,$buyCurrencyCode));

        $conversion = [
            "conversion_id" => $conversionInfo['id'],
            "conversion_settlement_date" => $conversionInfo['settlement_date'],
            "conversion_date" => $conversionInfo['conversion_date'],
            "conversion_short_reference" => $conversionInfo['short_reference'],
            "conversion_creator_contact_id" => $conversionInfo['creator_contact_id'],
            "account_id" => $conversionInfo['account_id'],
            "currency_pair" => $conversionInfo['currency_pair'],
            "conversion_status" => $conversionInfo['status'],
            "conversion_buy_currency" => $conversionInfo['buy_currency'],
            "conversion_sell_currency" => $conversionInfo['sell_currency'],
            "conversion_client_buy_amount" => $conversionInfo['client_buy_amount'],
            "conversion_client_sell_amount" => $conversionInfo['client_sell_amount'],
            "conversion_fixed_side" => $conversionInfo['fixed_side'],
            "conversion_core_rate" => $conversionInfo['core_rate'],
            "conversion_partner_rate" => $conversionInfo['partner_rate'],
            "conversion_partner_buy_amount" => $conversionInfo['partner_buy_amount'],
            "conversion_partner_sell_amount" => $conversionInfo['partner_sell_amount'],
            "conversion_client_rate" => $conversionInfo['client_rate'],
            "conversion_unallocated_funds" => $conversionInfo['unallocated_funds'],
            "conversion_unique_request_id" => $conversionInfo['unique_request_id'],
            "created_at" => $conversionInfo['created_at'],
            "updated_at" => $conversionInfo['updated_at'],
            "conversion_mid_market_rate" => $conversionInfo['mid_market_rate'],
        ];
        $meta = array_merge($finalConversion->meta, $conversion);
        $finalConversion->meta = $meta;
        $finalConversion->update();

        return view('international-transfer::conversion.process.final',compact('conversionInfo'));
    }

}
