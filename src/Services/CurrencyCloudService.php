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
        $updatedTime = Setting::where('key','cc_account_access_token')->first();
        $settings = Setting::pluck('value', 'key');
        if(!is_null($updatedTime))
        {
            $updatedAt = $updatedTime->updated_at->format('Y-m-d H:i:s');
            $oldtime = strtotime($updatedAt);
            $latesttime = strtotime(now()->format('Y-m-d H:i:s'));

            $timediff = round(abs($oldtime - $latesttime) / 60,2);

            if($timediff >= '30')
            {
                try {
                    $baseUrl = config('services.cc_account_url');
                   

                    $this->token = Http::asForm()->post($baseUrl . '/oauth/token', [
                        "grant_type" => "password",
                        "client_id" => $settings['cc_account_client_id'],
                        "client_secret" => $settings['cc_account_client_secret'],
                        "username" => $settings['cc_account_email'],
                        "password" => $settings['cc_account_password'],
                        "scope" => "",
                    ])->json('access_token');

                } catch (\Exception $exception) {

                    return $exception;
                }

                Setting::updateOrCreate(['key' => 'cc_account_access_token'],['key' => 'cc_account_access_token', 'value' => $this->token]);
            }
            else
            {
                $this->token = Setting::getValue('cc_account_access_token');
            }
        }
       
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
        return Http::withToken($this->token)
            ->post($this->apiUrl . 'currency-cloud-payout/', $data)
            ->throw()
            ->json();
    }

    public function ccAccount($data)
    {
        return Http::withToken($this->token)
            ->post($this->apiUrl . 'currency-cloud-account/', $data)
            ->throw()
            ->json();
    }

  
}
