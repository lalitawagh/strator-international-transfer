<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Enums\Role as EnumsRole;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\Role;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\PartnerFoundation\Workspace\Models\WorkspaceMeta;

class ConversionController extends Controller
{
    public function create()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        return view("international-transfer::conversion.process.create",compact('countries','defaultCountry'));
    }

    public function conversionPreview()
    {
        return view("international-transfer::conversion.process.preview");
    }

}
