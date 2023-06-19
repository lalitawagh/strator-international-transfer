<?php

namespace Kanexy\InternationalTransfer\Setting;

use Kanexy\Cms\Components\Contracts\Component;

class CcAccountSettingTab extends Component
{
    public function render()
    {
        return view("international-transfer::setting.cc-account-setting-tab");
    }
}
