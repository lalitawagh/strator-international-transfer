<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreCountryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'Sending_currency'       =>    ['required'],
            'Receiving_currency'       =>    ['required'],
        ];
    }

    public function messages()
    {
        return [

            'Sending_currency.required_if' => 'The Sending_currency field is required.',
            'Receiving_currency.required_if' => 'The Receiving_currency field is required.',

        ];
    }

}
