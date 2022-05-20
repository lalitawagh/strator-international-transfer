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

    public static function getExchangeRateWithAmount($from,$to,$amount)
    {
        try {
            $exchange_rate = Currency::convert()->from($from)->to($to)->amount($amount)->get();
            return $exchange_rate;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getExchangeRate($from,$to)
    {
        try {
            $exchange_rate = Currency::convert()->from($from)->to($to)->get();
            return $exchange_rate;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public static function getExchangeRateAmount($amount,$currency)
    {
        try {
            $amount =  $amount * 100;
            $money = money($amount,$currency);
            return $money;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
