<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Livewire\Component;

class ExistingBeneficiary extends Component
{
    public $count = 5;

    public $beneficiary;

    public function mount($workspace)
    {
        $this->workspace = $workspace;
    }

    public function render()
    {
        $beneficiaries = Contact::beneficiaries()->verified()->forWorkspace($this->workspace)->whereRefType('money_transfer')->latest()->take($this->count)->get();

        return view('international-transfer::livewire.existing-beneficiary', compact('beneficiaries'));
    }

    public function load()
    {
        $this->count += 5;
    }

    public function getBeneficiary($value)
    {
        $this->beneficiary = Contact::find($value);
        $this->dispatchBrowserEvent('confirmBeneficiary');
    }
}
