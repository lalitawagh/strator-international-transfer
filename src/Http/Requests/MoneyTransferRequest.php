<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
            'amount' => ['required','numeric','min:0'],
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
            'amount.min'         => 'The amount should not be a negative value.',
        ];
    }
}
