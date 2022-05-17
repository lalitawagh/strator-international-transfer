<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Illuminate\Support\Str;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Models\Log;
use Livewire\Component;

class TransactionLogComponent extends Component
{
    public Transaction $transaction;

    public $description;

    public $logs = [];

    protected $listeners = [
        'showTransactionLog',
        'refreshLogs' => '$refresh'
    ];

    public function showTransactionLog(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->logs = $this->transaction->logs;
    }

    public function render()
    {
        return view('international-transfer::livewire.transaction-log-component');
    }

    public function transactionLogSubmit(Transaction $transaction)
    {
        $log = new Log();
        $log->id = Str::uuid();
        $log->text = $this->description;
        $log->user_id = auth()->user()->id;
        $log->target()->associate($transaction);
        $log->save();

        $this->logs = $this->transaction->logs;

        $this->emit('refreshLogs');
    }
}
