<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreCountryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sending_currency'       =>    ['required'],
            'receiving_currency'     =>    ['required'],
        ];
    }

    public function messages()
    {
        return [

            'sending_currency.required'   => 'The Sending_currency field is required.',
            'receiving_currency.required' => 'The Receiving_currency field is required.',

        ];
    }

}
