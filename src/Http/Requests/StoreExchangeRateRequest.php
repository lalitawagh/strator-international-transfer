<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Kanexy\InternationalTransfer\Model\CcExchangeRate;
use Kanexy\InternationalTransfer\Contracts\ExchangeRateConfiguration;
use Kanexy\InternationalTransfer\Policies\ExchangeRatePolicy;

class StoreExchangeRateRequest extends FormRequest
{
    // public function authorize()
    // {
    //     if($this->user()->can(ExchangeRatePolicy::CREATE, ExchangeRateConfiguration::class))
    //     {
    //         return $this->user()->can(ExchangeRatePolicy::CREATE, ExchangeRateConfiguration::class);
    //     }

    //     return $this->user()->can(ExchangeRatePolicy::EDIT, ExchangeRateConfiguration::class);
    // }

    public function rules()
    {
        return [
            'exchange_from'      =>    'required',
            'exchange_to'        =>    'required',
            'rate_type'          =>    'required',
            'customized_rate'    =>    'required_if:rate_type,==,customize_rate',
            'plus_minus'         =>    'required_if:rate_type,==,currency_cloud_rate',
            'percentage'         =>    'required_if:rate_type,==,currency_cloud_rate',

        ];
    }

    public function messages()
    {
        return [
            'customized_rate.required_if' => 'the customized rate is required if rate type is customized rate',
            'percentage_rate.required_if' => 'the plus_minus is required if rate type is currency_cloud_rate',
            'percentage.required_if'      => 'the percentage is required if rate type is currency_clud_rate',
        ];
    }

}
