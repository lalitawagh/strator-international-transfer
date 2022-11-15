<?php

namespace Kanexy\InternationalTransfer\Http;

use AmrShawky\LaravelCurrency\Facade\Currency;
use Cknow\Money\Money;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class Helper
{
    public static function paginate($items, $perPage = 7, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => request()->url()]);
    }

    public static function getExchangeRateWithAmount($from, $to, $amount)
    {
        try {
            $exchange_rate = Currency::convert()->from($from)->to($to)->amount($amount)->get();
            return $exchange_rate;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getExchangeRate($from, $to)
    {
        try {
            $exchange_rate = Currency::convert()->from($from)->to($to)->get();
            return $exchange_rate;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getExchangeRateAmount($amount, $currency)
    {
        try {
            $money = Money::parseByDecimal($amount, $currency);
            return $money;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function totaProcessingInitialize($amount)
    {

        $url = "https://eu-test.oppwa.com/v1/checkouts";
        $data = "entityId=8ac9a4c983a8088b0183a852c336054a" .
            "&amount=$amount" .
            "&currency=GBP" .
            "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjOWE0Y2U4M2E4MmNkODAxODNhODUyYzIzMzAzMTZ8elR5NkE0WGVoVA=='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData);
    }
}
