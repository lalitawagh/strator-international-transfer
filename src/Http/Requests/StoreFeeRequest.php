<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Kanexy\InternationalTransfer\Contracts\FeeConfiguration;
use Kanexy\InternationalTransfer\Policies\FeePolicy;

class StoreFeeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can(FeePolicy::CREATE, FeeConfiguration::class);
    }

    public function rules()
    {
        return [
            'currency'       =>    ['required','string'],
            'type'           =>    ['required','string'],
            'payment_type'   =>    ['nullable','string'],
            'transfer_type'  =>    ['nullable','string'],
            'min_amount'     =>    ['required','numeric','min:0'],
            'max_amount'     =>    ['required','numeric','gt:min_amount'],
            'amount'         =>    ['nullable','numeric','min:0'],
            'percentage'     =>    ['nullable','numeric','between:0,100'],
            'status'         =>    ['required','string'],
        ];
    }

    public function messages()
    {
        return [
            'min_amount.min'        => 'The min amount should not be negative',
            'max_amount.gt'         => 'The max amount must be greater than min amount.',
            'amount.min'            => 'The amount should not be negative',
            'percentage.between'    => 'The percentage must be between 0 and 100',
        ];
    }
}
