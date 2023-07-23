<?php

namespace Kanexy\InternationalTransfer\Registration;

use Kanexy\Cms\Form\Contracts\Item;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\I18N\Models\Nationality;
use Kanexy\Cms\Models\Title;
use Kanexy\Cms\Setting\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\I18N\Models\Organization;
use Kanexy\Cms\Rules\AlphaSpaces;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;

class CustomerRegistrationForm extends Item
{
    public function validationRules(): array
    {
        return [
            'register_as_agent' => ['nullable'],
            'agent_name' => ['required_if:register_as_agent,on',new AlphaSpaces],
        ];
    }

    public function validationMessages(): array
    {
        return [
            'agent_name.required_if' => 'The agent name field is required.',
        ];
    }

    public function render()
    {
       
        if (!is_null(request()->input("type")) && request()->input("type") == "standard") {
            $isBankingUserType = !is_null(request()->input("type")) ? 1 : 0;
            $isBankingUser = (request()->input("type") == "standard") ? 2 : $isBankingUserType;

            $titles = Title::orderBy('id', 'asc')->pluck("name", "id");
            $nationalities = Nationality::pluck("nationality", "alpha_2_code");
            $countries = Country::orderBy("name")->pluck("name", "id");
            $countryWithFlags = Country::orderBy("name")->get();
            $defaultCountry = Country::find(Setting::getValue("default_country"));
            $organizations = Organization::orderBy("id", "asc")->pluck("occupation", "id");
            $purposeOfAccounts = Setting::getValue("purpose_of_account");
            $user = Auth::user();
            if (session('contactId')) {
                $isBankingUser = 1;
                $user = Contact::findOrFail(session('contactId'));
                $user->phone = $user?->mobile;
            }

            return view("international-transfer::registration.customer-registration", compact("titles", "countries", "defaultCountry", "countryWithFlags", "isBankingUser", "nationalities", "user", "organizations", "purposeOfAccounts"));
        }
    }
}
