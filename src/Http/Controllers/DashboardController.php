<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Models\UserSetting;
use Kanexy\LedgerFoundation\Model\Wallet;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Helper;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $workspace = null;

        $pieChartTransactions = Transaction::where('meta->transaction_type','money_transfer')->groupBy("status")->selectRaw("count(*) as data,upper(status) as label")->get();

        if (app('activeWorkspaceId')) {
            $workspace = Workspace::findOrFail(app('activeWorkspaceId'));
            $pieChartTransactions = Transaction::where('meta->transaction_type','money_transfer')->where("workspace_id", $workspace?->id)->groupBy("status")->selectRaw("count(*) as data,upper(status) as label")->get();
        }
        $transactions = Transaction::where("workspace_id", $workspace?->id)->where('meta->transaction_type','money_transfer')->latest()->take(5)->get();
        $yotiLog = UserSetting::whereUserId($user?->id)->first();

        $check_document_results = null;
        if(! empty($yotiLog))
        {
            $check_document_results = $this->getCheckResultData($yotiLog);
        }

        return view("international-transfer::money-transfer.dashboard", compact('transactions', 'workspace', 'pieChartTransactions', 'user', 'yotiLog', 'check_document_results'));
    }
}
