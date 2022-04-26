<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Illuminate\Support\Facades\Auth;
use Kanexy\InternationalTransfer\Http\Helper;
use Livewire\Component;

class InitialProcess extends Component
{
    public $countries;

    public $defaultCountry;

    public string $currency_from;

    public string $currency_to;

    public string $recipient_amount;

    public string $guaranteed_rate;


    public function mount($countries, $defaultCountry)
    {
        $this->countries = $countries;
        $this->defaultCountry = $defaultCountry;

    }

    public function changeFromCurrency($value)
    {
        $this->currency_from = $value;
        $this->dispatchBrowserEvent('UpdateLivewireSelect');
        $this->dispatchBrowserEvent('disabledSelectedCountry', ['currency' => $value]);
    }

    public function changeToCurrency($value)
    {
        $this->currency_to = $value;
        $this->dispatchBrowserEvent('UpdateLivewireSelect');
        $this->dispatchBrowserEvent('disabledSelectedCountry', ['currency' => $this->currency_from]);
    }

    public function changeAmount($value)
    {
        if($this->currency_from != '' && $this->currency_to != '')
        {
            $amount = Helper::getExchangeRateWithAmount($this->currency_from,$this->currency_to,$value);
            $exchange_rate = Helper::getExchangeRate($this->currency_from,$this->currency_to);
        }
        $this->recipient_amount = $amount;
        $this->guaranteed_rate = $exchange_rate;
        $this->dispatchBrowserEvent('UpdateLivewireSelect');
    }

    public function render()
    {

        return view('international-transfer::livewire.initial-process');
    }


}
