<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Livewire\Component;

class TransactionDetailComponent extends Component
{
    public Transaction $transaction;

    public $masterAccount;

    protected $listeners = [
        'showTransactionDetail',
    ];

    public function showTransactionDetail(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->masterAccount =  collect(Setting::getValue('money_transfer_master_account_details',[]));
        $this->dispatchBrowserEvent('show-transaction-detail-modal');
    }

    public function render()
    {
       return view('international-transfer::livewire.transaction-detail-component');
    }
}
