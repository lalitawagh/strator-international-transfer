<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Kanexy\InternationalTransfer\Contracts\FeeConfiguration;
use Kanexy\InternationalTransfer\Policies\FeePolicy;

class StoreFeeRequest extends FormRequest
{
    public function authorize()
    {
        if($this->user()->can(FeePolicy::CREATE, FeeConfiguration::class))
        {
            return $this->user()->can(FeePolicy::CREATE, FeeConfiguration::class);
        }

        return $this->user()->can(FeePolicy::EDIT, FeeConfiguration::class);
    }

    public function rules()
    {
        return [
            'type'           =>    ['required','string'],
            'min_amount'     =>    ['required','numeric','min:0'],
            'max_amount'     =>    ['required','numeric','gt:min_amount'],
            'fee_type'       =>    ['required'],
            'amount'         =>    ['required_if:fee_type,==,amount','nullable','numeric','min:0'],
            'percentage'     =>    ['required_if:fee_type,==,percentage','nullable','numeric','between:0,100','min:0'],
            'status'         =>    ['required','string'],
        ];
    }

    public function messages()
    {
        return [
            'min_amount.min'        => 'The min amount should not be a negative value.',
            'max_amount.gt'         => 'The max amount must be greater than min amount.',
            'amount.min'            => 'The amount should not be a negative value.',
            'percentage.between'    => 'The percentage must be between 0 and 100.',
            'amount.required_if' => 'The amount field is required.',
            'percentage.required_if' => 'The percentage field is required.',
        ];
    }
}
