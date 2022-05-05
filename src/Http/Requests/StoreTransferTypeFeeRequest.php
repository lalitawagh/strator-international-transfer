<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Kanexy\InternationalTransfer\Contracts\TransferTypeFeeConfiguration;
use Kanexy\InternationalTransfer\Policies\TransferTypeFeePolicy;

class StoreTransferTypeFeeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can(TransferTypeFeePolicy::CREATE, TransferTypeFeeConfiguration::class);
    }

    public function rules()
    {
        return [
            'currency'       =>    ['required','string'],
            'type'           =>    ['required','string',Rule::in(['payment_type', 'transfer_type'])],
            'payment_type'   =>    ['required_if:type,==,payment_type'],
            'transfer_type'  =>    ['required_if:type,==,transfer_type'],
            'min_amount'     =>    ['required','numeric'],
            'max_amount'     =>    ['required','numeric'],
            'amount'         =>    ['nullable','numeric'],
            'percentage'     =>    ['nullable','numeric'],
            'status'         =>    ['required','string'],
            'description'    =>    ['nullable','string'],
        ];
    }

    public function messages()
    {
        return [
            'payment_type.required_if' => 'The payment type field is required',
            'transfer_type.required_if' => 'The transfer type field is required',
            'type.in' => 'The type field is required',
        ];
    }
}
