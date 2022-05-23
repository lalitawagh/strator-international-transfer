<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration;
use Kanexy\InternationalTransfer\Policies\MasterAccountPolicy;

class StoreMasterAccountRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can(MasterAccountPolicy::CREATE, MasterAccountConfiguration::class);
    }

    public function rules()
    {
        return [
            'account_holder_name'   =>    ['required','string'],
            'account_branch'        =>    ['required','string'],
            'account_number'        =>    ['required','numeric','digits:8'],
            'sort_code'             =>    ['required','numeric','digits:6'],
            'beneficiary_id'        =>    ['required'],
        ];
    }

}
