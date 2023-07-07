<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;

class BalanceController extends Controller
{
    public function create()
    {
        return view("international-transfer::balance.balance");
    }
}
