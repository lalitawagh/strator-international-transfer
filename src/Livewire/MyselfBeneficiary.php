<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\Cms\Helper;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Notifications\SmsOneTimePasswordNotification;
use Kanexy\Cms\Rules\AlphaSpaces;
use Kanexy\Cms\Rules\LandlineNumber;
use Kanexy\Cms\Rules\MobileNumber;
use Kanexy\InternationalTransfer\Enums\Beneficiary;
use Kanexy\PartnerFoundation\Banking\Enums\BankEnum;
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

    public $first_name;

    public $middle_name;

    public $last_name;

    public $company_name;

    public $country;

    public $email;

    public $mobile;

    public $landline;

    public $bank_account_name;

    public $iban_number;

    public $account_number;

    public $swift_code;

    public $sort_no;

    public $note;

    public $avatar;

    public $type;

    public $classification = ['beneficiary'];

    public $beneficiary_created;

    public $oneTimePassword;

    public $beneficiaryType;

    public $contact;

    public $meta;

    public $sending_country;

    public $receiving_country;


    protected function rules()
    {
        return  [
            'type' => ['required', 'string'],
            'email' => ['nullable','email'],
            'mobile' => ['nullable',new MobileNumber],
            'first_name' => ['required_if:type,personal', 'nullable', new AlphaSpaces, 'string','max:40'],
            'middle_name' => ['nullable',new AlphaSpaces, 'string','max:40'],
            'last_name' =>  ['required_if:type,personal', 'nullable', new AlphaSpaces, 'string','max:40'],
            'landline' => ['nullable', 'string', new LandlineNumber],
            'avatar' => ['nullable', 'max:5120', 'mimes:png,jpg,jpeg', 'file'],
            'note' => ['nullable'],
            'meta' => ['required', 'array'],
            'meta.iban_number' => ['required'],
            'meta.bank_account_name' => ['required', 'string'],
            'meta.bank_account_number' => ['required', 'string', 'numeric', 'digits:8'],
            'meta.bank_code' => ['required_if:receiving_country,==,UK','nullable', 'string', 'numeric', 'digits:6'],
            'company_name'   => ['required_if:type,business', 'nullable', new AlphaSpaces, 'string','max:40'],
        ];
    }

    protected $validationAttributes = [
        'first_name' => 'first name',
        'middle_name' => 'middle name',
        'last_name' => 'last name',
        'email' => 'email',
        'mobile' => 'mobile',
        'bank_account_name' => 'account holder name',
        'company_name' => 'company',
        'meta.bank_account_number' => 'bank account number',
        'meta.bank_code' => 'bank sort code',
        'meta.bank_account_name' => 'bank account name',
        'meta.iban_number' => 'IBAN Number',
        'meta.bank_country' => 'country'
    ];

    protected function messages()
    {
        return  [
            'meta.bank_code.required_if' => 'The sort code field is required.',
        ];
    }


    public function mount($countries, $defaultCountry, $user, $account, $workspace, $beneficiaryType)
    {
        $this->countries = $countries;
        $this->defaultCountry = $defaultCountry;
        $this->user = $user;
        $this->account = $account;
        $this->workspace_id = $workspace->id;
        $this->beneficiaryType = $beneficiaryType;
        $this->sending_country = Country::find(session('money_transfer_request.currency_code_from'))->code;
        $this->receiving_country = Country::find(session('money_transfer_request.currency_code_to'))->code;
        $this->type = ($beneficiaryType == Beneficiary::MYSELF || $beneficiaryType == Beneficiary::SOMEONE_ELSE) ? 'personal': 'business';
        if(($beneficiaryType == Beneficiary::MYSELF))
        {
            $this->first_name =  $user->first_name;
            $this->middle_name =  $user->middle_name;
            $this->last_name =  $user->last_name;
            $this->email =  $user->email;
            $this->mobile = ! is_null(session('mobile')) ? session('mobile') : $user->phone;
        }
        $this->dispatchBrowserEvent('UpdateLivewireSelect');

    }

    public function changeCountry($value)
    {
        $this->country = $value;
    }

    public function createBeneficiary()
    {
        $data =  $this->validate();

        if($data['type'] == 'business'){
            $data['display_name'] = $data['company_name'];
        }else{
            $data['display_name'] = implode(' ', [$data['first_name'], $data['middle_name'], $data['last_name']]);
        }

        if(! is_null($this->avatar))
        {
            $data['avatar'] = $this->avatar->store('Images', 'azure');
        }

        $currencyDetails = [
            'sending_currency' => session('money_transfer_request.currency_code_from'),
            'receiving_currency' => session('money_transfer_request.currency_code_to'),
            'bank_code_type' => BankEnum::SORTCODE,
            'bank_country' => session('money_transfer_request.currency_code_to') ? session('money_transfer_request.currency_code_to')  : $this->country,
        ];

        if(! is_null($data['mobile']))
        {
            $data['mobile'] = Helper::normalizePhone($data['mobile']);
        }

        $data['workspace_id'] = $this->workspace_id;
        $data['ref_type'] = 'money_transfer';
        $data['classification'] = $this->classification;
        $data['meta'] = array_merge($data['meta'],$currencyDetails);
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

        session(['contact' => $contact, 'oneTimePassword' => $this->oneTimePassword]);

        //$user->generateOtp("sms");
        $this->beneficiary_created = true;

        $this->dispatchBrowserEvent('showOtpModel',['modalType' => $this->beneficiaryType]);

    }

    public function render()
    {
        return view('international-transfer::livewire.myself-beneficiary');
    }
}
