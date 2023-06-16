<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdatePartnerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title_id'          => ['required', 'exists:titles,id'],
            'first_name'        => ['required', 'string', 'max:20'],
            'middle_name'       => ['nullable', 'string', 'max:20'],
            'last_name'         => ['required', 'string', 'max:20'],
            'email'             => ['required', Rule::unique('partners')->ignore($this->id),"email","regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix"],
            'phone'             => ['required', Rule::unique('partners')->ignore($this->id), 'numeric', 'regex:/^((07|7))[0-9]{9}$/'],
            'country_id'        => ['required', 'exists:countries,id'],
            'country_code'      => ['required', 'exists:countries,phone'],
            'webhook_url'       => ['required'],
            'status'            => ['nullable'],
        ];
    }
}
