<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
            'type'        =>    ['required','string'],
            'min_amount'  =>    ['required','numeric'],
            'max_amount'  =>    ['required','numeric'],
            'amount'      =>    ['nullable','numeric'],
            'percentage'  =>    ['nullable','numeric'],
            'status'      =>    ['required','string'],
        ];
    }
}
