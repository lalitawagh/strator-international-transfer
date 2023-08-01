<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Livewire\Component;
use Kanexy\InternationalTransfer\Models\CcAccount;

class TransactionDetailComponent extends Component
{
    public Transaction $transaction;

    public $masterAccount;

    public $subAccounts;

    protected $listeners = [
        'showTransactionDetail',
    ];

    public function showTransactionDetail(Transaction $transaction)
    {
        $this->transaction = $transaction;
        if($this->transaction->meta['base_currency'] == 'GBP' )
        {
            $this->masterAccount = collect(Setting::getValue('money_transfer_master_account_details',[]))->firstWhere('country',231);
            $this->subAccounts = CcAccount::where(['ref_type' => 'currency_cloud','holder_id' => $transaction?->workspace_id])->first();
        }else{
            $country = Country::where('currency',$this->transaction->meta['base_currency'])->first();
            $this->masterAccount = collect(Setting::getValue('money_transfer_master_account_details',[]))->firstWhere('country',$country->id);
            $this->subAccounts = CcAccount::where(['ref_type' => 'currency_cloud','holder_id' => $transaction?->workspace_id])->first();                           
        }

        $this->dispatchBrowserEvent('show-transaction-detail-modal');
    }

    public function render()
    {
       return view('international-transfer::livewire.transaction-detail-component');
    }
}
