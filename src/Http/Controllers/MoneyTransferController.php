<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;

class MoneyTransferController extends Controller
{
    public function index()
    {
        return view('international-transfer::money-transfer.index');
    }

    public function create()
    {
        return view('international-transfer::money-transfer.process.create');
    }
}
