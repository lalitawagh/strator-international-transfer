<?php

namespace Kanexy\InternationalTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Kanexy\InternationalTransfer\Contracts\CollectionAccountConfiguration;
use Kanexy\InternationalTransfer\Policies\CollectionAccountPolicy;

class StoreCollectionAccountRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can(CollectionAccountPolicy::CREATE, CollectionAccountConfiguration::class);
    }

    public function rules()
    {
        return [
            'account_holder_name'   =>    ['required','string'],
            'account_branch'        =>    ['required','string'],
            'account_number'        =>    ['required','numeric'],
            'sort_code'             =>    ['required','numeric'],
        ];
    }
}
