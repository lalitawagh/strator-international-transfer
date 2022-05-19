<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Livewire\Component;

class TransactionTrackComponent extends Component
{
    public Transaction $transaction;


    protected $listeners = [
        'showTransactionTrack',
    ];

    public function showTransactionTrack(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
       return view('international-transfer::livewire.transaction-track-component');
    }
}
