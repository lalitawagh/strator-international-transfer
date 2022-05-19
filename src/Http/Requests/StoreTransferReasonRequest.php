<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Kanexy\InternationalTransfer\Contracts\TransferReasonConfiguration;
use Kanexy\InternationalTransfer\Policies\TransferReasonPolicy;

class StoreTransferReasonRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can(TransferReasonPolicy::CREATE, TransferReasonConfiguration::class);
    }

    public function rules()
    {
        return [
            'reason'      =>    ['required','string','regex:/^[\s\w-]*$/'],
            'status'      =>    ['required','string'],
        ];
    }

    public function messages()
    {
        return [
            'reason.regex' => 'The reason field may only contain letters, numbers and spaces.',
        ];
    }
}
