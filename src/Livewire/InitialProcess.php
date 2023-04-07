<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Carbon\Carbon;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\CurrencyCloud\Dtos\RateDetailedExchangeDto;
use Kanexy\CurrencyCloud\Services\CurrencyCloudApiService;
use Kanexy\InternationalTransfer\Enums\Status;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\PartnerFoundation\Core\Enums\ExchangeCurrencyEnum;
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

    public $feeMethod;

    protected $listeners = [
        'changeToMethod',
    ];

    public function mount($countries, $defaultCountry)
    {
        $this->countries = $countries;

        $this->defaultCountry = $defaultCountry;

        $this->currency_from = $defaultCountry->id;

        $this->fees = collect(Setting::getValue('money_transfer_type_fees', []))
        ->where('currency', $this->currency_from)
        ->all();

        $this->amount = old('amount') ? old('amount') : 1000;

        $this->currency_from = Country::whereCode('UK')->first()->id;

        $this->currency_to =  Country::whereCode('IN')->first()->id;

        $this->getDetails();

    }


    public function hydrate()
    {
        $this->dispatchBrowserEvent('transfer-on-process');
    }


    public function dehydrate()
    {
        $this->dispatchBrowserEvent('can-transfer');
    }
    public function changeFromCurrency($value)
    {
        $this->currency_from = $value;

        $this->getDetails();

        $this->fees =  collect(Setting::getValue('money_transfer_type_fees', []))
                        ->where('currency', $value)
                        ->all();

        $this->dispatchBrowserEvent('UpdateLivewireSelect');

        $this->dispatchBrowserEvent('disabledSelectedCountry', ['currency' => $value]);
    }

    public function changeToCurrency($value)
    {
        $this->currency_to = $value;

        $this->getDetails();

        $this->dispatchBrowserEvent('UpdateLivewireSelect');
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


    public function updated($propertyName)
    {
            if ($propertyName=='amount') {

                $this->changeAmount($this->amount);
            }
    }

    public function changeAmount($value)
    {
        if (!empty($value) && $value != '.') {

            $this->amount = $value;
            $this->getDetails();
        }

        $this->dispatchBrowserEvent('UpdateLivewireSelect');
    }

    public function getDetails()
    {
        $this->from = (isset($this->currency_from))
        ? Country::Find($this->currency_from)?->currency
        : Country::whereCode('UK')->first()->currency;

        $this->to =  (isset($this->currency_to))
        ? Country::Find($this->currency_to)?->currency
        : Country::whereCode('IN')->first()->currency;

        $exchangeRateIntegration = Setting::where('key', 'exhange_rate_integration')->first();
        if($exchangeRateIntegration?->value == ExchangeCurrencyEnum::CURRENCY_CLOUD)
        {
            $service = new CurrencyCloudApiService();

            $param = [
                'buy_currency' => $this->from,
                'sell_currency' => $this->to,
                'amount' => $this->amount,
                'fixed_side' => 'sell',
                'conversion_date' => Carbon::now()->format('Y-m-d'),
            ];
            $response = $service->getDetailedRate(new RateDetailedExchangeDto($param));

            if($response['code'] == 200)
            {
                $exchangeRate = $response['core_rate'];
            }else{
                $exchangeRate = 1;
            }

        }else{
            $exchangeRate = Helper::getExchangeRate($this->from, $this->to);
        }


        $this->recipient_amount = $this->amount;
        $this->guaranteed_rate = $exchangeRate;
        $this->guaranteed_rate = number_format((float) $this->guaranteed_rate, 2, '.', '');

        $this->initial_fee = collect(Setting::getValue('money_transfer_type_fees', []))
        ->where('currency', $this->currency_from)
        ->where('min_amount', '<=', $this->amount)
        ->where('max_amount', '>=', $this->amount)
        ->first();

        if (!is_null($this->initial_fee)) {

            if ($this->initial_fee['status'] == Status::ACTIVE) {

                $this->fee_charge = ($this->initial_fee['percentage'] == 0)
                ?  $this->initial_fee['amount']
                : $this->amount * ($this->initial_fee['percentage']/100);

                $this->feeMethod =  $this->initial_fee['id'];

            } else {
                $this->fee_charge = 0;
                $this->feeMethod =  0;
            }

        } else {

            $this->fee_charge = 0;
            $this->feeMethod =  0;
        }

        $this->fee_charge = number_format((float) $this->fee_charge, 2, '.', '');

        if (!empty($this->amount) && $this->amount != '.') {

            $this->fee_deduction_amount = $this->amount - $this->fee_charge;
            $this->recipient_amount = $this->fee_deduction_amount * $this->guaranteed_rate;
            $this->recipient_amount = number_format((float) $this->recipient_amount, 2, '.', '');
        }
    }

    public function render()
    {
        return view('international-transfer::livewire.initial-process');
    }

}
