<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Livewire\Component;

class TransactionDetailComponent extends Component
{
    public Transaction $transaction;


    protected $listeners = [
        'showTransactionDetail',
    ];

    public function showTransactionDetail(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
       return view('international-transfer::livewire.transaction-detail-component');
    }
}
