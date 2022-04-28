<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
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

    public string $from;

    public string $to;

    public $fees;

    public string $fee_charge;

    public string $fee_deduction_amount;

    public string $actual_amount;

    public function mount($countries, $defaultCountry)
    {
        $this->countries = $countries;
        $this->defaultCountry = $defaultCountry;

    }

    public function changeFromCurrency($value)
    {
        $this->currency_from = $value;
        $this->fees =  collect(Setting::getValue('money_transfer_type_fees',[]))->where('currency', $value)->all();
        $this->dispatchBrowserEvent('UpdateLivewireSelect');
        $this->dispatchBrowserEvent('disabledSelectedCountry', ['currency' => $value]);
    }

    public function changeToCurrency($value)
    {
        $this->currency_to = $value;
        $this->dispatchBrowserEvent('UpdateLivewireSelect');
        $this->dispatchBrowserEvent('disabledSelectedCountry', ['currency' => $this->currency_from]);
    }

    public function changeToMethod($value)
    {
        $this->fee_charge = $value;
        $this->fee_deduction_amount = $this->actual_amount - $this->fee_charge;
        $this->recipient_amount = $this->fee_deduction_amount * $this->guaranteed_rate;
        $this->dispatchBrowserEvent('UpdateLivewireSelect');
    }

    public function changeAmount($value)
    {

        $this->from = (isset($this->currency_from)) ? Country::Find($this->currency_from)?->currency : Country::whereCode('UK')->first()->currency;
        $this->to =  (isset($this->currency_to)) ? Country::Find($this->currency_to)?->currency : Country::whereCode('AD')->first()->currency;
        $amount = Helper::getExchangeRateWithAmount($this->from,$this->to,$value);
        $exchange_rate = Helper::getExchangeRate($this->from,$this->to);

        $this->actual_amount = $value;
        $this->recipient_amount = $value;
        $this->guaranteed_rate = $exchange_rate;
        $this->dispatchBrowserEvent('UpdateLivewireSelect');
    }

    public function render()
    {
        return view('international-transfer::livewire.initial-process');
    }

}
