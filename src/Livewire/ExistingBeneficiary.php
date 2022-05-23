<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Livewire\Component;

class ExistingBeneficiary extends Component
{
    public $count = 5;

    public $beneficiaryDetail;

    public function mount($workspace)
    {
        $this->workspace = $workspace;
    }

    public function render()
    {
        $beneficiaries = Contact::beneficiaries()->verified()->forWorkspace($this->workspace)->whereRefType('money_transfer')->where(['meta->bank_country' => session('money_transfer_request.currency_code_to')])->orderBy('id','desc')->take($this->count)->get();

        return view('international-transfer::livewire.existing-beneficiary', compact('beneficiaries'));
    }

    public function load()
    {
        $this->count += 5;
    }

    public function getBeneficiary($value)
    {
        $this->beneficiaryDetail = Contact::find($value);

        $requestTransfer = session('money_transfer_request');
        $requestTransfer['beneficiary_id'] = $this->beneficiaryDetail->id;

        session(['money_transfer_request' => $requestTransfer]);

        $this->dispatchBrowserEvent('confirmBeneficiary');
    }
}
