<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreCountryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sending_currency'       =>    'required',
            'receiving_currency'     =>    'required|different:sending_currency',
        ];
    }

    public function messages()
    {
        return [

            'sending_currency.required'   => 'The Sending Currency field is required.',
            'receiving_currency.required' => 'The Receiving Currency field is required.',
            'receiving_currency.different' => 'The receiving currency must be different from the sending currency.',

        ];
    }

}
