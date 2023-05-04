<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\InternationalTransfer\Contracts\MoneyTransfer;
use Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy;

class MoneyTransferRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can(MoneyTransferPolicy::CREATE, MoneyTransfer::class);
    }

    public function rules()
    {
        return [
            'currency_code_from' => ['required', 'exists:countries,id'],
            'currency_code_to' => ['required', 'exists:countries,id'],
            'amount' => ['required','numeric','min:0.50','max:10000000'],
            'fee_charge' => ['required'],
            'guaranteed_rate' => ['required'],
            'recipient_amount' => ['required','numeric','min:0'],
            'workspace_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'recipient_amount.min'  => 'The recipient amount should not be a negative value.',
            'amount.min' => 'The smallest amount you can send is 0.50',
            'amount.max' => 'The most you can send is 10000000',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $sender = Country::find($this->input('currency_code_from'));
            $receiver = Country::find($this->input('currency_code_to'));

            if($sender->code != 'UK')
            {
                $validator->errors()->add('country', 'Please send the amount in GBP(United Kingdom).');
            }

            if($sender->code == 'UK' && $receiver->code == 'UK')
            {
                $validator->errors()->add('country', 'Please click on Local button for Local transaction.');
            }
        });
    }
}
