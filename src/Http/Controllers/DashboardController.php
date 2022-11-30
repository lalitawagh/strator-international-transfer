<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\LedgerFoundation\Model\Wallet;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $workspace = null;

        if ($request->has('filter.workspace_id')) {
            $workspace = Workspace::findOrFail($request->input('filter.workspace_id'));
        }
        $transactions = Transaction::where("workspace_id", $workspace?->id)->where('meta->account','money-transfer')->latest()->take(5)->get();

        return view("international-transfer::money-transfer.dashboard", compact('transactions', 'workspace'));
    }
}
