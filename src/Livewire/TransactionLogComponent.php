<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Models\Log;
use Livewire\Component;

class TransactionLogComponent extends Component
{
    public Transaction $transaction;

    public $description;

    public $logSent;

    public $logs;

    protected $listeners = [
        'showTransactionLog',
        'refreshComponent' => '$refresh',
        'clearInput'
    ];

    protected function rules()
    {
        return [
            'description' => 'required|max:250',
        ];

    }

    public function mount()
    {
        $this->transaction = new Transaction();
    }
    public function showTransactionLog(Transaction $transaction)
    {

        $this->transaction = $transaction;

    }
    public function transactionLogSubmit(Transaction $transaction)
    {
        $data = $this->validate();

        $log = new Log();
        $log->id = Str::uuid();
        $log->text = $data['description'];
        $log->user_id = auth()->user()->id;
        $log->target()->associate($transaction);
        $log->save();

        $this->logSent = true;

        $this->emit('clearInput');

        $this->logs = Log::query()
            ->where([
                'target_type' => $transaction->getMorphClass(),
                'target_id' => $transaction->id
            ])
            ->whereNull('meta')
            ->latest()
            ->get();

    }

    public function clearInput()
    {
        $this->logSent = false;
        $this->description = null;
    }

    public function loadTransactionLogs(string $targetModel, int|null $targetId): Collection
    {
        return Log::query()
            ->with('user')
            ->where([
                'target_type' => $targetModel,
                'target_id' => $targetId,
            ])
            ->whereNull('meta')
            ->latest()
            ->get();
    }

    public function render()
    {
        $transactionLogs = $this->loadTransactionLogs($this->transaction->getMorphClass(), $this->transaction->id);

        return view('international-transfer::livewire.transaction-log-component', [
            'transactionLogs' => $transactionLogs
        ]);
    }
}
