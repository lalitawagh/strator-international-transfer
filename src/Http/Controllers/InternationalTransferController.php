<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Routing\Controller;

class InternationalTransferController extends Controller
{
    public function index()
    {
        return view("international-transfer::index");
    }
}
