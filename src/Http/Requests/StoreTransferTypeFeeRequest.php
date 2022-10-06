<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\TransferTypeFeeConfiguration;
use Kanexy\InternationalTransfer\Policies\TransferTypeFeePolicy;

class StoreTransferTypeFeeRequest extends FormRequest
{
    public function authorize()
    {
        if($this->user()->can(TransferTypeFeePolicy::CREATE, TransferTypeFeeConfiguration::class))
        {
            return $this->user()->can(TransferTypeFeePolicy::CREATE, TransferTypeFeeConfiguration::class);
        }

        return $this->user()->can(TransferTypeFeePolicy::EDIT, TransferTypeFeeConfiguration::class);
    }

    public function rules()
    {
        return [
            'currency'       =>    ['required','string'],
            'type'           =>    ['required','string',Rule::in(['payment_type', 'transfer_type'])],
            'payment_type'   =>    ['required_if:type,==,payment_type','nullable','regex:/^[\s\w-]*$/'],
            'transfer_type'  =>    ['required_if:type,==,transfer_type','nullable','regex:/^[\s\w-]*$/'],
            'min_amount'     =>    ['required','numeric','min:0'],
            'max_amount'     =>    ['required','numeric','gt:min_amount'],
            'fee_type'       =>    ['required'],
            'amount'         =>    ['required_if:fee_type,==,amount','nullable','numeric','min:0'],
            'percentage'     =>    ['required_if:fee_type,==,percentage','nullable','numeric','between:0,100'],
            'status'         =>    ['required','string'],
            'description'    =>    ['nullable','string'],
        ];
    }

    public function messages()
    {
        return [
            'payment_type.required_if' => 'The payment type field is required.',
            'transfer_type.required_if' => 'The transfer type field is required.',
            'type.in' => 'The type field is required.',
            'amount.required_if' => 'The amount field is required.',
            'percentage.required_if' => 'The percentage field is required.',
            'min_amount.min'        => 'The min amount should not be a negative value.',
            'max_amount.gt'         => 'The max amount must be greater than min amount.',
            'amount.min'            => 'The amount should not be a negative value.',
            'percentage.between'    => 'The percentage must be between 0 and 100.',
            'payment_type.regex' => 'The payment type field may only contain letters, numbers and spaces.',
            'transfer_type.regex' => 'The transfer type field may only contain letters, numbers and spaces.',

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $currency = collect(Setting::getValue('money_transfer_type_fees',[]))->firstWhere('currency', $this->input('currency'));
            if(!is_null($currency))
            {
                if($currency['type'] != $this->input('type'))
                {
                    $validator->errors()->add('type', "This country's Type filed has already been selected. Please select the same Type.");
                }
            }
        });
    }
}
