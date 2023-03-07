<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Illuminate\Support\Facades\Auth;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Livewire\Component;

class CurrencyCloudPayoutComponent extends Component
{

    public Transaction $transaction;

    protected $listeners = [
        'showCurrencyCloudPayout',
    ];

    public function showCurrencyCloudPayout(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->dispatchBrowserEvent('show-currencycloud-payout');
    }

    public function render()
    {
       return view('international-transfer::livewire.currency-cloud-payout-component');
    }
}
