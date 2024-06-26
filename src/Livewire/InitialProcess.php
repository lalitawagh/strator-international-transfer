<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Carbon\Carbon;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\CurrencyCloud\Dtos\RateDetailedExchangeDto;
use Kanexy\CurrencyCloud\Services\CurrencyCloudApiService;
use Kanexy\InternationalTransfer\Enums\Status;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Models\CcExchangeRate;
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

    public $sendingCurrency;

    public $receivingCurrency;

    public $sendingcountriesinfo;

    public $receivingcountriesinfo;

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

        $this->amount = session('money_transfer_request.amount') ? session('money_transfer_request.amount') : 1000;

        $from = @Setting::getValue('international-transfer_sending_currency',[])[0] ? @Setting::getValue('international-transfer_sending_currency',[])[0] :  231;
        $to = @Setting::getValue('international-transfer_receiving_currency',[])[0] ? @Setting::getValue('international-transfer_receiving_currency',[])[0] : 105;

        $this->currency_from = Country::whereId($from)->first()?->id;

        $this->currency_to =  Country::whereId($to)->first()?->id;

        $this->countryCurrency = Country::whereIn('currency',['AUD','CAD','CZK','DKK','EUR','GBP','USD','HUF','INR','NOK','RON','SEK'])->get();

        $this->sendingCurrency = Setting::getValue('international-transfer_sending_currency',[]);

        $this->receivingCurrency = Setting::getValue('international-transfer_receiving_currency', []);

        $this->sendingcountriesinfo = Country::whereIn('id',$this->sendingCurrency)->get();

        $this->receivingcountriesinfo = Country::whereIn('id',$this->receivingCurrency)->get();

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

        if (config('services.registration_changed') == true)
        {
            $membershipExchangeRates = WorkspaceMeta::where(['key' => 'exchangerate_info','workspace_id' => app('activeWorkspaceId')])->first();

            $globalExchangeRate = CcExchangeRate::where('exchange_to',$this->currency_to)->first();

            if(!is_null($globalExchangeRate))
            {
                if(@$globalExchangeRate->rate_type == 'customized_rate')
                {
                    $exchangeRate = $globalExchangeRate->customized_rate;

                }elseif(@$globalExchangeRate->rate_type == 'default_rate'){

                    $percentage = @$globalExchangeRate->percentage;

                    $percent = $percentage / 100  * $exchangeRate;

                    if( @$globalExchangeRate->plus_minus == 'plus')
                    {
                        $exchangeRate = $exchangeRate + $percent;
                    }else{
                        $exchangeRate = $exchangeRate - $percent;
                    }
                }

            }
            else{

                if (!empty($membershipExchangeRates) && $membershipExchangeRates !== null) {

                    if(@$membershipExchangeRates->value['rate_type'] == 'customized_rate')
                    {
                        if(!is_null(@$membershipExchangeRates->value['customized_rate']))
                        {
                            $exchangeRate = @$membershipExchangeRates->value['customized_rate'];
                        }


                    }
                    else
                    {
                        if(!is_null(@$membershipExchangeRates->value['percentage'])) {
                            $percentage = @$membershipExchangeRates->value['percentage'];

                            $percent = $percentage / 100  * $exchangeRate;

                            if(@$membershipExchangeRates->value['percentage_rate'] == 'plus') {
                                $exchangeRate = $exchangeRate + $percent;
                            } else {
                                $exchangeRate = $exchangeRate - $percent;
                            }
                        }
                    }

                }
            }

        }
        $this->recipient_amount = $this->amount;
        $this->guaranteed_rate = $exchangeRate;
        $this->guaranteed_rate =number_format((float) $this->guaranteed_rate, 2, '.', '');

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
