<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Kanexy\InternationalTransfer\Contracts\RiskMgmtQueConfiguration;
use Kanexy\InternationalTransfer\Policies\RiskMgmtQuePolicy;

class StoreRiskMgmtQueRequest extends FormRequest
{
    public function authorize()
    {
        if($this->user()->can(RiskMgmtQuePolicy::CREATE, RiskMgmtQueConfiguration::class))
        {
            return $this->user()->can(RiskMgmtQuePolicy::CREATE, RiskMgmtQueConfiguration::class);
        }

        return $this->user()->can(RiskMgmtQuePolicy::EDIT, RiskMgmtQueConfiguration::class);
    }

    public function rules()
    {
        return [
            'questions'      =>    ['required','string'],
            'status'      =>    ['required','string'],
            'answer'       =>    ['required'],
            'yes'         =>    ['required_if:answer,==,yes','nullable','numeric','min:0'],
            'no'     =>    ['required_if:answer,==,no','nullable','numeric','min:0'],
        ];
    }

    public function messages()
    {
        return [
            'yes.required_if' => 'The score yes field is required.',
            'no.required_if' => 'The score no field is required.',
        ];
    }

}
