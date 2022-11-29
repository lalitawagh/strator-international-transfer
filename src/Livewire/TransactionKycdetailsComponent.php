<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\Cms\Models\UserSetting;
use Kanexy\PartnerFoundation\Banking\Models\Account;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Models\Document;
use Kanexy\PartnerFoundation\Membership\Models\Membership;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Livewire\Component;

class TransactionKycdetailsComponent extends Component
{
    public $workspace;

    public $membership;

    public $user;

    public $memberships;

    public $account;

    public $yotiLog;

    public $railsbankKYC;

    public  $documents;

    public $documentStatuses;

    public $check_document_results;


    protected $listeners = [
        'showTransactionKYCDetails',
    ];

    public function showTransactionKYCDetails($workspaceId)
    {
        $this->transaction = Transaction::findOrFail($workspaceId);
        $this->workspace =  $this->transaction->workspace()->first();
        $this->user = $this->workspace->users()->first();
        $this->yotiLog = UserSetting::whereUserId($this->user->id)->first();
        $this->documents = $this->user->documents()->get();
        $this->dispatchBrowserEvent('show-transactionkyc-details');
    }

    public function render()
    {

       return view('international-transfer::livewire.transaction-kycdetails-component');
    }
}
