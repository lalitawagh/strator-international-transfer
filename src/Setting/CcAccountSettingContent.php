<?php

namespace Kanexy\InternationalTransfer\Setting;

use Kanexy\Cms\Components\Contracts\Component;
use Kanexy\Cms\Setting\Models\Setting;

class CcAccountSettingContent extends Component
{
    public function render()
    {
        $settings = Setting::pluck('value', 'key');
        return view("international-transfer::setting.cc-account-setting-content", compact('settings'));
    }
}
