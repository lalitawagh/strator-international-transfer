<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Kanexy\InternationalTransfer\Models\CcExchangeRate;
use Kanexy\InternationalTransfer\Contracts\ExchangeRateConfiguration;
use Kanexy\InternationalTransfer\Policies\ExchangeRatePolicy;

class StoreExchangeRateRequest extends FormRequest
{
    public function authorize()
    {
        if($this->user()->can(ExchangeRatePolicy::CREATE, ExchangeRateConfiguration::class))
        {
            return $this->user()->can(ExchangeRatePolicy::CREATE, ExchangeRateConfiguration::class);
        }

        return $this->user()->can(ExchangeRatePolicy::EDIT, ExchangeRateConfiguration::class);
    }

    public function rules()
    {
        return [
            'exchange_from'      =>    'required_if:rate_type,==,customized_rate',
            'exchange_to'        =>    'required_if:rate_type,==,customized_rate',
            'rate_type'          =>    'required',
            'customized_rate'    =>    'required_if:rate_type,==,customized_rate',
            'plus_minus'         =>    'required_if:rate_type,==,default_rate',
            'percentage'         =>    'required_if:rate_type,==,default_rate',

        ];
    }

    public function messages()
    {
        return [
            'customized_rate.required_if' => 'the customized rate is required if rate type is customized rate',
            'exchange_from.required_if'   => 'the exchange_from is required if rate type is customized rate',
            'exchange_to.required_if'     => 'the exchange_to is required if rate type is customized rate',
            'percentage_rate.required_if' => 'the plus_minus is required if rate type is default rate',
            'percentage.required_if'      => 'the percentage is required if rate type is default rate',
        ];
    }


}
