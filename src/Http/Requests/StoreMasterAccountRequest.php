<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Kanexy\Cms\Rules\AlphaSpaces;
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
            'account_holder_name'   =>    ['required','string', new AlphaSpaces(), 'max:20'],
            'account_branch'        =>    ['required','string','max:20'],
            'account_number'        =>    ['required','numeric'],
            'sort_code'             =>    [Rule::requiredIf(request()->get('country') == 231),'nullable','numeric','digits:6'],
            'ifsc_code'             =>    [Rule::requiredIf(request()->get('country') != 231),'nullable'],
        ];
    }
}
