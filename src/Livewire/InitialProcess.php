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
use Kanexy\PartnerFoundation\Workspace\Models\WorkspaceMeta;
use Livewire\Component;

use function PHPUnit\Framework\isEmpty;

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

    public $countryCurrency;

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

        $this->countryCurrency = Country::whereIn('currency',['EUR','GBP','INR','PKR','USD'])->get();

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
                'buy_currency' => $this->to,
                'sell_currency' => $this->from,
                'amount' => $this->amount,
                'fixed_side' => 'sell',
                'conversion_date' => Carbon::now()->format('Y-m-d'),
            ];

            $response = $service->getDetailedRate(new RateDetailedExchangeDto($param));
            if($response['code'] == 200)
            {
                Setting::updateOrCreate(['key' => 'currency_cloud_exchange_rate'],['key' => 'currency_cloud_exchange_rate', 'value' => $response['core_rate']]);
                $currencyCloudExchnageRate = Setting::getValue('currency_cloud_exchange_rate');
                if(!is_null($currencyCloudExchnageRate))
                {
                    $exchangeRate = $currencyCloudExchnageRate;
                }
                else{
                    $exchangeRate = 1;
                }
            }
            else
            {
                $currencyCloudExchnageRate = Setting::getValue('currency_cloud_exchange_rate');
                if(!is_null($currencyCloudExchnageRate))
                {
                    $exchangeRate = $currencyCloudExchnageRate;
                }
                else{
                    $exchangeRate = 1;
                }
            }

        }else{
            $exchangeRate = Helper::getExchangeRate($this->from, $this->to);
        }

        // if (config('services.registration_changed') == true)
        // {
        //     $exchangeRates = WorkspaceMeta::where(['key' => 'exchangerate_info','workspace_id' => app('activeWorkspaceId')])->first();

        //     if(isEmpty($exchangeRates == 'exchangerate_info')){
        //         if(@$exchangeRates->value['rate_type'] == 'customize_rate')
        //         {
        //             $exchangeRate = @$exchangeRates->value['customized_rate'];
        //         }
        //         else
        //         {
        //             $percentage = @$exchangeRates->value['percentage'];
        //             $percent = $percentage / 100  * $exchangeRate;
        //             if( @$exchangeRates->value['percentage_rate'] == 'plus')
        //             {
        //                 $exchangeRate = $exchangeRate + $percent;
        //             }else{
        //                 $exchangeRate = $exchangeRate - $percent;
        //             }
        //         }
        //     }
        // }

        if (config('services.registration_changed') == true)
        {
            $exchangeRates = collect(Setting::getValue('cc_rate_type',[]));
            dd($exchangeRates);

            if(isEmpty($exchangeRates == 'exchangerate_info')){
                if(@$exchangeRates->value['rate_type'] == 'ccc_customize_rate')
                {
                    $exchangeRate = @$exchangeRates->value['cc_customized_rate'];
                }
                else
                {
                    $percentage = @$exchangeRates->value['cc_percentage'];
                    $percent = $percentage / 100  * $exchangeRate;
                    if( @$exchangeRates->value['cc_percentage_rate'] == 'plus')
                    {
                        $exchangeRate = $exchangeRate + $percent;
                    }else{
                        $exchangeRate = $exchangeRate - $percent;
                    }
                }
            }
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
