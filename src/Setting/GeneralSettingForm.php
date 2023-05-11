<?php

namespace Kanexy\InternationalTransfer\Setting;

use Kanexy\Cms\Components\Contracts\Component;
use Kanexy\Cms\Form\Contracts\Item;
use Kanexy\Cms\Setting\Models\Setting;

class GeneralSettingForm extends Item
{
    public $exchangeRateData;

    public function validationRules(): array
    {
        return [
            'cc_rate_type' => 'required',
            'cc_customized_rate' => 'nullable|numeric',
            'cc_percentage_rate' => 'nullable',
            'cc_percentage' => 'nullable|numeric',
        ];

    }

    public function render()
    {
        $settings = Setting::pluck('value', 'key');
        $rate_type = Setting::getValue('cc_rate_type',[]);
            $customized_rate = Setting::getValue('cc_customized_rate',[]);
            $percentage_rate = Setting::getValue('cc_percentage_rate',[]);
            $percentage = Setting::getValue('cc_percentage',[]);
        return view("international-transfer::setting.general-setting-form", compact('settings','rate_type','customized_rate','percentage_rate','percentage'));
    }
}
