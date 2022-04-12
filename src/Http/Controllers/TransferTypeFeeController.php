<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Routing\Controller;

class TransferTypeFeeController extends Controller
{
    public function index()
    {
        return view("international-transfer::configuration");
    }
}
