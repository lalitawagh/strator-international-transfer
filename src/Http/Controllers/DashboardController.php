<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Models\UserSetting;
use Kanexy\InternationalTransfer\Models\CcAccount;
use Kanexy\InternationalTransfer\Services\CurrencyCloudService;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Kanexy\PartnerFoundation\Workspace\Models\WorkspaceMeta;

class DashboardController extends Controller
{
    public function index(Request $request,CurrencyCloudService $service)
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
        $kycSkip = WorkspaceMeta::where(['workspace_id' => $workspace?->id, 'key' => 'skip_kyc'])->first();

        $check_document_results = null;
        if (config('services.registration_changed') == false)
        {
            if($kycSkip?->value == 'true')
            {
                if(! empty($yotiLog))
                {
                    $check_document_results = $this->getCheckResultData($yotiLog);

                }
            }
        }


        $recentTransactions = Transaction::where('meta->transaction_type', 'money_transfer')->latest()->take(15)->get();
        $recentUserTransactions = Transaction::where('meta->transaction_type', 'money_transfer')->where("workspace_id", $workspace?->id)->latest()->take(15)->get();

        $subAccountInfo = CcAccount::where(['holder_id' => $workspace?->id])->first();

        return view("international-transfer::money-transfer.dashboard", compact('transactions', 'workspace', 'pieChartTransactions', 'recentTransactions', 'user','yotiLog', 'check_document_results', 'recentUserTransactions', 'kycSkip','subAccountInfo'));
    }
}
