<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Kanexy\Cms\Helper;
use Kanexy\Cms\Notifications\SmsOneTimePasswordNotification;
use Kanexy\Cms\Rules\AlphaSpaces;
use Kanexy\Cms\Rules\LandlineNumber;
use Kanexy\Cms\Rules\MobileNumber;
use Kanexy\PartnerFoundation\Banking\Enums\ContactType;
use Kanexy\PartnerFoundation\Cxrm\Events\ContactCreated;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Livewire\Component;
use Livewire\WithFileUploads;

class MyselfBeneficiary extends Component
{
    use WithFileUploads;

    public $countries;

    public $defaultCountry;

    public $user;

    public $account;

    public  $first_name;

    public  $middle_name;

    public  $last_name;

    public  $company_name;

    public  $country;

    public  $email;

    public  $mobile;

    public  $phone;

    public  $bank_account_name;

    public  $iban_number;

    public  $account_number;

    public  $swift_code;

    public  $note;

    public  $avatar;

    public  $type;

    public $classification = ['beneficiary'];


    public function mount($countries, $defaultCountry, $user, $account, $workspace)
    {
        $this->countries = $countries;
        $this->defaultCountry = $defaultCountry;
        $this->user = $user;
        $this->account = $account;
        $this->workspace_id = $workspace->id;
    }

    public function createBeneficiary()
    {
        $data = $this->validate([
            'first_name' => ['required_if:type,==,personal' ,new AlphaSpaces, 'string','max:40'],
            'middle_name' => ['nullable',new AlphaSpaces, 'string','max:40'],
            'last_name' => ['required_if:type,==,personal',new AlphaSpaces, 'string','max:40'],
            'email' => ['required','email'],
            'mobile' => ['required',new MobileNumber],
            'phone' => ['nullable',new LandlineNumber],
            'avatar' => ['nullable','image'],
            'swift_code' => 'required',
            'iban_number' => 'nullable',
            'bank_account_name' => 'required',
            'account_number' => 'required',
            'company_name'   => 'required_if:type,==,company',
            'type' => ['required', 'string', Rule::in(ContactType::toArray())],

        ]);

        if($data['type'] == 'company'){
            $data['display_name'] = $data['company_name'];
        }else{
            $data['display_name'] = implode(' ', [$data['first_name'], $data['middle_name'], $data['last_name']]);
        }

        $data['avatar'] = $this->avatar->store('Images', 'azure');


        $data['mobile'] = Helper::normalizePhone($data['mobile']);
        $data['workspace_id'] = $this->workspace_id;
        $data['ref_type'] = 'money_transfer';
        $data['classification'] = $this->classification;
        $data['status'] = 'active';

         /** @var Contact $contact */
        $contact = Contact::create($data);

        event(new ContactCreated($contact));

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $this->contact = $contact;

        $user->notify(new SmsOneTimePasswordNotification($contact->generateOtp("sms")));
        // $contact->generateOtp("sms");
        $this->oneTimePassword = $this->contact->oneTimePasswords()->first()->id;
        //$user->generateOtp("sms");

        $this->beneficiary_created = true;
        $this->dispatchBrowserEvent('showOtpModel');

    }

    public function render()
    {
        return view('international-transfer::livewire.myself-beneficiary');
    }
}
