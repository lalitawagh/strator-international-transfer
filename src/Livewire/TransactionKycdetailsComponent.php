<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Kanexy\Cms\Models\UserSetting;
use Kanexy\InternationalTransfer\Enums\FlagStatus;
use Kanexy\PartnerFoundation\Core\Models\Transaction;

class TransactionKycdetailsComponent extends Component
{
    public $workspace;

    public $user;

    public $yotiLog;

    public $documents;

    public $flag;

    public $success_status = false;

    public $error_status = false;

    public $message;

    protected $listeners = [
        'showTransactionKYCDetails',
    ];

    protected function rules()
    {
        return  [
            'flag' => ['required', 'string', Rule::in(FlagStatus::FLAG_STATUS)]
        ];
    }

    protected $validationAttributes = [
        'flag' => 'Flag',
    ];

    protected function messages()
    {
        return  [
            'flag.required' => 'The flag is required.'
        ];
    }

    public function handleflagChange($values)
    {
        $this->flag = $values;
    }

    public function showTransactionKYCDetails($workspaceId)
    {
        $this->transaction = Transaction::findOrFail($workspaceId);
        $this->workspace =  $this->transaction->workspace()->first();
        $this->user = $this->workspace->users()->first();
        $this->yotiLog = UserSetting::whereUserId($this->user?->id)->first();
        $this->documents = $this->user?->documents()->get();
        $this->dispatchBrowserEvent('show-transactionkyc-details');
    }

    public function updateFlag()
    {

        $this->success_status = false;

        $this->validate();

        $data = [
            'user_id' => $this->user?->id,
            'key' => 'kyc_flag',
            'value' => str_replace('"', '', $this->flag)
        ];

        UserSetting::updateOrCreate(
            ['user_id' => $this->user?->id, 'key' => 'kyc_flag'],
            $data
        );

        $this->message = 'Flag Updated Successfully';

        $this->success_status = true;
    }

    public function render()
    {

        return view('international-transfer::livewire.transaction-kycdetails-component');
    }
}
