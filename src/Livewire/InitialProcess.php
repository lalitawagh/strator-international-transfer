<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Enums\Status;
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

    public  $amount;

    public  $initial_fee;

    protected $listeners = [
        'changeToMethod',
    ];

    public function mount($countries, $defaultCountry)
    {
        $this->countries = $countries;
        $this->defaultCountry = $defaultCountry;
        $this->currency_from = $defaultCountry->id;
        $this->fees = collect(Setting::getValue('money_transfer_type_fees',[]))->where('currency', $this->currency_from)->all();
        $this->amount = 1000;
        $this->from = Country::whereCode('UK')->first()->currency;
        $this->to =  Country::whereCode('IN')->first()->currency;
        $this->guaranteed_rate = Helper::getExchangeRate($this->from,$this->to);
        $this->guaranteed_rate = number_format((float) $this->guaranteed_rate, 2, '.', '');
        $this->initial_fee = collect(Setting::getValue('money_transfer_type_fees',[]))->firstWhere('currency', $defaultCountry->id);
        if(!is_null($this->initial_fee))
        {
            if($this->initial_fee['status'] == Status::ACTIVE)
            {
                $this->fee_charge = ( $this->initial_fee['percentage'] == 0) ?  $this->initial_fee['amount'] : $this->amount * ( $this->initial_fee['percentage']/100);
            }else{
                $this->fee_charge = 0;
            }
        }else{
            $this->fee_charge = 0;
        }

        $this->fee_charge = number_format((float) $this->fee_charge, 2, '.', '');
        $this->fee_deduction_amount = $this->amount - $this->fee_charge;
        $this->recipient_amount = $this->fee_deduction_amount * $this->guaranteed_rate;
        $this->recipient_amount = number_format((float) $this->recipient_amount, 2, '.', '');

    }

    public function changeFromCurrency($value)
    {
        $this->currency_from = $value;

        $this->from = (isset($this->currency_from)) ? Country::Find($this->currency_from)?->currency : Country::whereCode('UK')->first()->currency;
        $this->to =  (isset($this->currency_to)) ? Country::Find($this->currency_to)?->currency : Country::whereCode('IN')->first()->currency;
        $exchange_rate = Helper::getExchangeRate($this->from,$this->to);

        $this->recipient_amount = $this->amount;
        $this->guaranteed_rate = $exchange_rate;
        $this->guaranteed_rate = number_format((float) $this->guaranteed_rate, 2, '.', '');
        $this->initial_fee = collect(Setting::getValue('money_transfer_type_fees',[]))->firstWhere('currency', $value);

        if(!is_null($this->initial_fee))
        {
            if($this->initial_fee['status'] == Status::ACTIVE)
            {
                $this->fee_charge = ( $this->initial_fee['percentage'] == 0) ?  $this->initial_fee['amount'] : $this->amount * ( $this->initial_fee['percentage']/100);
            }else{
                $this->fee_charge = 0;
            }
        }else{
            $this->fee_charge = 0;
        }

        $this->fee_charge = number_format((float) $this->fee_charge, 2, '.', '');

        if(!empty($this->amount))
        {
            $this->fee_deduction_amount = $this->amount - $this->fee_charge;
            $this->recipient_amount = $this->fee_deduction_amount * $this->guaranteed_rate;
            $this->recipient_amount = number_format((float) $this->recipient_amount, 2, '.', '');
        }

        $this->fees =  collect(Setting::getValue('money_transfer_type_fees',[]))->where('currency', $value)->all();
        $this->dispatchBrowserEvent('UpdateLivewireSelect');
        $this->dispatchBrowserEvent('disabledSelectedCountry', ['currency' => $value]);
    }

    public function changeToCurrency($value)
    {
        $this->currency_to = $value;

        $this->from = (isset($this->currency_from)) ? Country::Find($this->currency_from)?->currency : Country::whereCode('UK')->first()->currency;
        $this->to =  (isset($this->currency_to)) ? Country::Find($this->currency_to)?->currency : Country::whereCode('IN')->first()->currency;
        $exchange_rate = Helper::getExchangeRate($this->from,$this->to);

        $this->recipient_amount = $this->amount;
        $this->guaranteed_rate = $exchange_rate;
        $this->guaranteed_rate = number_format((float) $this->guaranteed_rate, 2, '.', '');

        if(!is_null($this->initial_fee))
        {
            if($this->initial_fee['status'] == Status::ACTIVE)
            {
                $this->fee_charge = ( $this->initial_fee['percentage'] == 0) ?  $this->initial_fee['amount'] : $this->amount * ( $this->initial_fee['percentage']/100);
            }else{
                $this->fee_charge = 0;
            }
        }else{
            $this->fee_charge = 0;
        }

        $this->fee_charge = number_format((float) $this->fee_charge, 2, '.', '');

        if(!empty($this->amount))
        {
            $this->fee_deduction_amount = $this->amount - $this->fee_charge;
            $this->recipient_amount = $this->fee_deduction_amount * $this->guaranteed_rate;
            $this->recipient_amount = number_format((float) $this->recipient_amount, 2, '.', '');
        }

        $this->dispatchBrowserEvent('UpdateLivewireSelect');
        $this->dispatchBrowserEvent('disabledSelectedCountry', ['currency' => $this->currency_from]);
    }

    public function changeToMethod($value)
    {
        $this->fee_charge = $value;
        $this->fee_charge = number_format((float) $this->fee_charge, 2, '.', '');
        $this->fee_deduction_amount = $this->amount - $this->fee_charge;
        $this->recipient_amount = $this->fee_deduction_amount * $this->guaranteed_rate;
        $this->recipient_amount = number_format((float) $this->recipient_amount, 2, '.', '');

        $this->dispatchBrowserEvent('UpdateLivewireSelect');
    }

    public function changeAmount($value)
    {

        $this->from = (isset($this->currency_from)) ? Country::Find($this->currency_from)?->currency : Country::whereCode('UK')->first()->currency;
        $this->to =  (isset($this->currency_to)) ? Country::Find($this->currency_to)?->currency : Country::whereCode('IN')->first()->currency;

        if(!empty($value))
        {
            $amount = Helper::getExchangeRateWithAmount($this->from,$this->to,$value);
            $exchange_rate = Helper::getExchangeRate($this->from,$this->to);

            $this->amount = $value;
            $this->recipient_amount = $value;
            $this->guaranteed_rate = $exchange_rate;
            $this->guaranteed_rate = number_format((float) $this->guaranteed_rate, 2, '.', '');

            if(!is_null($this->initial_fee))
            {
                if($this->initial_fee['status'] == Status::ACTIVE)
                {
                    $this->fee_charge = ( $this->initial_fee['percentage'] == 0) ?  $this->initial_fee['amount'] : $value * ( $this->initial_fee['percentage']/100);
                }else{
                    $this->fee_charge = 0;
                }
            }else{
                $this->fee_charge = 0;
            }

            $this->fee_charge = number_format((float) $this->fee_charge, 2, '.', '');
            $this->fee_deduction_amount = $value - $this->fee_charge;
            $this->recipient_amount = $this->fee_deduction_amount * $this->guaranteed_rate;
            $this->recipient_amount = number_format((float) $this->recipient_amount, 2, '.', '');
        }

        $this->dispatchBrowserEvent('UpdateLivewireSelect');
    }

    public function render()
    {
        return view('international-transfer::livewire.initial-process');
    }

}
