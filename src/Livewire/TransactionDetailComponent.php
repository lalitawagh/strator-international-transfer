<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
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
        if($this->transaction->meta['base_currency'] == 'GBP' )
        {
            $this->masterAccount = collect(Setting::getValue('money_transfer_master_account_details',[]))->firstWhere('country',231);
        }else{
            $country = Country::where('currency',$this->transaction->meta['base_currency'])->first();
            $this->masterAccount = collect(Setting::getValue('money_transfer_master_account_details',[]))->firstWhere('country',$country->id);
        }

        $this->dispatchBrowserEvent('show-transaction-detail-modal');
    }

    public function render()
    {
       return view('international-transfer::livewire.transaction-detail-component');
    }
}
