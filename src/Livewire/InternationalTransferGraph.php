<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Illuminate\Support\Facades\Auth;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Helper;
use Livewire\Component;

class InternationalTransferGraph extends Component
{
    private $months = [];

    public $selectedYear, $creditTransactionGraphData;

    public $debitTransactionGraphData;

    public $years = [];

    public function mount()
    {
        $years = Transaction::groupBy("year")->orderBy("year", "DESC")->selectRaw("YEAR(created_at) as year")->get();
        $this->years = $years->pluck("year")->toArray();
        $this->selectedYear = date('Y');
        $this->selectYear($this->selectedYear);
    }
    
    public function selectYear($year)
    {
        $this->selectedYear = $year;

        foreach (range(1, 12) as $m) {
            $this->months[] = date('F', mktime(0, 0, 0, $m, 1));
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $currentWorkspaceId = app('activeWorkspaceId');

        if($currentWorkspaceId = app('activeWorkspaceId'))
        {
            $debitTransactionGraph = Transaction::whereYear("created_at", $this->selectedYear)->groupBy(["label"])->selectRaw("ROUND(sum(amount),2) as data, MONTHNAME(created_at) as label")->where('workspace_id', $currentWorkspaceId)->where('meta->transaction_type','money_transfer')->where('archived','!=',1)->get();
        }else
        {
            $debitTransactionGraph = Transaction::whereYear("created_at", $this->selectedYear)->groupBy(["label"])->selectRaw("ROUND(sum(amount),2) as data, MONTHNAME(created_at) as label")->where('meta->transaction_type','money_transfer')->where('archived','!=',1)->get();
        }

        $debitTransactionGraphData = collect($this->months)->map(function ($month) use ($debitTransactionGraph) {
            $record = $debitTransactionGraph->where('label', $month)->first();


            if (!is_null($record)) {
                return $record->data;
            }

            return 0;
        });

        $this->debitTransactionGraphData = $debitTransactionGraphData;


        $this->dispatchBrowserEvent('UpdateTransactionChart');

        $this->emit('closeDropdown');
    }

    public function render()
    {
        return view('international-transfer::livewire.international-transfer-graph');
    }
}
