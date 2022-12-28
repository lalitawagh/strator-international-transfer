<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRiskManagementRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'high_risk_country' => ['required', 'exists:countries,id'],
            'low_risk_country' => ['required', 'exists:countries,id'],
        ];
    }
}
