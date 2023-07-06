<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;

class BalanceController extends Controller
{
    public function index()
    {
        return view("international-transfer::balance.balance");
    }
}
