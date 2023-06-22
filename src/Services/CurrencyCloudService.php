<?php

namespace Kanexy\InternationalTransfer\Services;

use Illuminate\Support\Facades\Http;
use Kanexy\Cms\Setting\Models\Setting;

class CurrencyCloudService
{
    private string $apiUrl;

    private string $baseUrl;

    private string $token;

    public function __construct() {
        $baseUrl = config('services.cc_account_url');

        $this->apiUrl = $baseUrl ;

        $this->setupAccessToken();
    }

    public function setupAccessToken()
    {
        $this->token = Setting::getValue('cc_account_access_token');
    }

    public function getBalance($currency)
    {
        return Http::withToken($this->token)
            ->get($this->apiUrl . 'get-balance/' . $currency)
            ->throw()
            ->json();
    }

    public function payout($data)
    {
       dd($data);
        return Http::withToken($this->token)
            ->post($this->apiUrl . 'currency-cloud-payout/', $data)
            ->throw()
            ->json();
    }

  
}
