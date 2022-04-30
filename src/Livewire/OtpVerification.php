<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Livewire\Component;

class OtpVerification extends Component
{
    public $countries;

    public $defaultCountry;

    public $user;

    public $account;

    public $workspace;

    public function mount($countries, $defaultCountry, $user, $account, $workspace)
    {
        $this->countries = $countries;
        $this->defaultCountry = $defaultCountry;
        $this->user = $user;
        $this->account = $account;
        $this->workspace_id = $workspace->id;
    }

    public function render()
    {
        return view('international-transfer::livewire.otp-verification');
    }
}
