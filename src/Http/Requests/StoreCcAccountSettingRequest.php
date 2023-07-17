<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCcAccountSettingRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'cc_account_client_id' => ['required'],
            'cc_account_client_secret' => ['required'],
            'cc_account_email' => ['required', 'email'],
            'cc_account_password' => ['required'],
            'cc_account_environment' => ['required'],
        ];
    }
}
