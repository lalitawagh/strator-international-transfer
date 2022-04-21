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
            'type'           =>    ['required','string'],
            'payment_type'   =>    ['nullable','string'],
            'transfer_type'  =>    ['nullable','string'],
            'min_amount'     =>    ['required','numeric'],
            'max_amount'     =>    ['required','numeric'],
            'amount'         =>    ['nullable','numeric'],
            'percentage'     =>    ['nullable','numeric'],
            'status'         =>    ['required','string'],
        ];
    }
}
