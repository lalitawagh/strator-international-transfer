<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration;
use Kanexy\InternationalTransfer\Policies\MasterAccountPolicy;

class StoreMasterAccountRequest extends FormRequest
{
    public function authorize()
    {
        if($this->user()->can(MasterAccountPolicy::CREATE, MasterAccountConfiguration::class))
        {
            return $this->user()->can(MasterAccountPolicy::CREATE, MasterAccountConfiguration::class);
        }

        return $this->user()->can(MasterAccountPolicy::EDIT, MasterAccountConfiguration::class);
    }

    public function rules()
    {
        return [
            'country'               =>    ['required','exists:countries,id'],
            'status'                =>    ['required'],
            'account_holder_name'   =>    ['required','string','regex:/(^([a-zA-Z]+)(\d+)?$)/u'],
            'account_branch'        =>    ['required','string'],
            'account_number'        =>    ['required','numeric','size:15'],
            'sort_code'             =>    [Rule::requiredIf(request()->get('country') == 231),'nullable','numeric','digits:6'],
            'ifsc_code'             =>    [Rule::requiredIf(request()->get('country') != 231),'nullable'],
        ];
    }
    public function messages()
    {
        return [
            'account_holder_name.regex'   =>    'Account Holder Name should not Contain Numbers and Characters',
            'account_number.size'        =>    'Account Number Maximum size is 15',
        ];
    }

}
