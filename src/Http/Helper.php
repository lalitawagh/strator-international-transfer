<?php

namespace Kanexy\InternationalTransfer\Http;

use AmrShawky\LaravelCurrency\Facade\Currency;
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
        $exchange_rate = Currency::convert()->from($from)->to($to)->amount($amount)->get();
        return $exchange_rate;
    }

    public static function getExchangeRate($from,$to)
    {
        $exchange_rate = Currency::convert()->from($from)->to($to)->get();
        return $exchange_rate;
    }

}
