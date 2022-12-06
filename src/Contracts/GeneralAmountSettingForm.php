<?php

namespace Kanexy\InternationalTransfer\Contracts;

use Kanexy\Cms\Components\Contracts\Component;
use Kanexy\Cms\Form\Contracts\Item;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\PartnerFoundation\Saas\Models\Plan;

class GeneralAmountSettingForm extends Item
{
    public function validationRules(): array
    {
        return [
            'transaction_threshold_amount' => ['nullable', 'numeric'],
        ];
    }

    public function render()
    {
        $settings = Setting::pluck('value', 'key');

        return view("international-transfer::configuration.settingform", compact('settings'));
    }
}
