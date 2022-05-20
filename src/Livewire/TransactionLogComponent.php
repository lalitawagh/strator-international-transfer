<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Illuminate\Support\Str;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Models\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class TransactionLogComponent extends Component
{
    use WithFileUploads;

    public Transaction $transaction;

    public $description;

    public $attachment;

    public $logSent;

    public $logs = [];

    protected $listeners = [
        'showTransactionLog',
        'refreshComponent' => '$refresh'
    ];

    public function showTransactionLog(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->logs = Log::where(['target_type' => $transaction->getMorphClass(),'target_id' => $transaction->id])->latest()->get();

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

        if(! is_null($this->attachment))
        {
            $data['attachment'] = $this->attachment->store('Images', 'azure');
            $log->meta = $data;
        }

        $log->save();

        // $this->emit('refreshComponent');
        $this->logs = Log::where(['target_type' => $transaction->getMorphClass(),'target_id' => $transaction->id])->latest()->get();
        $this->logSent = true;
    }
}
