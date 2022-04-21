<?php

namespace Kanexy\InternationalTransfer\Facades;

use Illuminate\Support\Facades\Facade;

class InternationalTransfer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kanexy\InternationalTransfer\InternationalTransfer::class;
    }
}
