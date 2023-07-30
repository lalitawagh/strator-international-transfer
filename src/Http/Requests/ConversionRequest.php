<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\InternationalTransfer\Contracts\MoneyTransfer;
use Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy;

class ConversionRequest extends FormRequest
{

    public function rules()
    {
        return [
            'currency_sell' => ['nullable'],
            'currency_buy' => ['nullable'],
            'amount_to' => ['nullable'],
            'sell' => ['nullable','numeric','min:0.50','max:10000000'],
            'buy' => ['nullable','numeric','min:0.50','max:10000000'],
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'recipient_amount.min'  => 'The recipient amount should not be a negative value.',
    //         'amount.min' => 'The smallest amount you can send is 0.50',
    //         'amount.max' => 'The most you can send is 10000000',
    //     ];
    // }

}
