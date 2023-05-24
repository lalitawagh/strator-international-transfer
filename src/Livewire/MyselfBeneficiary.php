<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\Cms\Helper;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Notifications\EmailOneTimePasswordNotification;
use Kanexy\Cms\Notifications\SmsOneTimePasswordNotification;
use Kanexy\Cms\Rules\AlphaSpaces;
use Kanexy\Cms\Rules\LandlineNumber;
use Kanexy\Cms\Rules\MobileNumber;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Enums\Beneficiary;
use Kanexy\InternationalTransfer\Enums\ShortCode;
use Kanexy\PartnerFoundation\Core\Rules\BeneficiaryUnique;
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

    public $ach_routing_number;

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

    public $bsb_number;

    public $aba_number;

    public $bic_number;

    public $cnaps_number;

    protected function rules()
    {
        return  [
            'type' => ['required', 'string'],
            'email' => ['nullable','email'],
            'mobile' => ['nullable','digits_between:10,11'],
            'first_name' => ['required_if:type,personal', 'nullable', new AlphaSpaces, 'string','max:40'],
            'middle_name' => ['nullable',new AlphaSpaces, 'string','max:40'],
            'last_name' =>  ['required_if:type,personal', 'nullable', new AlphaSpaces, 'string','max:40'],
            'landline' => ['nullable', 'string', new LandlineNumber],
            'avatar' => ['nullable', 'max:5120', 'mimes:png,jpg,jpeg', 'file'],
            'note' => ['nullable'],
            'meta' => ['required', 'array'],
            'meta.benficiary_address' => ['required','max:40'],
            'meta.benficiary_city' => ['required',new AlphaSpaces,'max:40'],
            'meta.iban_number' => ['required'],
            'meta.bank_account_name' => ['required', new AlphaSpaces,'max:40'],
            'meta.bank_account_number' => ['required', 'string', 'numeric', 'digits_between:8,16'],
            'meta.bank_code' => ['required_if:receiving_country,==,UK','nullable', 'string', 'numeric', 'digits:6'],
            'company_name'   => ['required_if:type,business', 'nullable', new AlphaSpaces, 'string','max:40'],
            'meta.ach_routing_number' => ['string', 'numeric'],
            'meta.bsb_number' => ['string', 'numeric'],
            'meta.aba_number' => ['string', 'numeric'],
            'meta.bic_number' => ['string', 'numeric'],
            'meta.cnaps_number' => ['string', 'numeric'],
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
        'meta.bank_country' => 'country',
        'meta.benficiary_address' => 'Address',
        'meta.benficiary_city' => 'City',
        'meta.ach_routing_number' => 'ACH Routing Number',
        'meta.bsb_number' => 'BSB Number',
        'meta.aba_number' => 'ABA Number',
        'meta.bic_number' => 'BIC Number',
        'meta.cnaps_number' => 'CNAPS Number',
    ];

    protected function messages()
    {
        return  [
            'meta.bank_code.required_if' => 'The sort code field is required.',
            'meta.iban_number.required' => 'The IFSC code/ IBAN field is required.',
            'meta.bank_account_name.regex' =>'Account Name contains Letters and Spaces Only',
            'meta.beneficiary_address.required' => 'The address field is required',
            'meta.ach_routing_number' => 'The ACH Routing Number field is required',
            'meta.bsb_number' => 'The BSB Number field is required',
            'meta.aba_number' => 'The ABA Number field is required',
            'meta.bic_number' => 'The BIC Number field is required',
            'meta.cnaps_number' => 'The CNAPS Number field is required',
        ];
    }

    public function mount($countries, $defaultCountry, $user, $workspace, $beneficiaryType)
    {
        $this->countries = $countries;
        $this->defaultCountry = $defaultCountry;
        $this->user = $user;
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

    public function selectBeneficiaryType($value)
    {
        $this->type = $value;
        $this->dispatchBrowserEvent('UpdateLivewireSelect');
    }

    public function createBeneficiary()
    {
        $this->dispatchBrowserEvent('UpdateLivewireSelect');
        $data =  $this->validate();
        
        if(isset($data['meta']['bank_code']))
        {
            $contactExist = Contact::beneficiaries()->verified()
            ->where("workspace_id", $this->workspace_id)
            ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
            ->where('meta->bank_code', $data['meta']['bank_code'])
            ->first();
        }elseif (isset($data['meta']['iban_number'])){
            $contactExist = Contact::beneficiaries()->verified()
            ->where("workspace_id", $this->workspace_id)
            ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
            ->where('meta->iban_number', $data['meta']['iban_number'])
            ->first();
        }elseif (isset($data['meta']['bsb_number'])){
            $contactExist = Contact::beneficiaries()->verified()
            ->where("workspace_id", $this->workspace_id)
            ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
            ->where('meta->bsb_number', $data['meta']['bsb_number'])
            ->first();
        }elseif (isset($data['meta']['aba_number'])){
            $contactExist = Contact::beneficiaries()->verified()
            ->where("workspace_id", $this->workspace_id)
            ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
            ->where('meta->aba_number', $data['meta']['aba_number'])
            ->first();
        }elseif (isset($data['meta']['bic_number'])){
            $contactExist = Contact::beneficiaries()->verified()
            ->where("workspace_id", $this->workspace_id)
            ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
            ->where('meta->bic_number', $data['meta']['bic_number'])
            ->first();
        }elseif (isset($data['meta']['cnaps_number'])){
            $contactExist = Contact::beneficiaries()->verified()
            ->where("workspace_id", $this->workspace_id)
            ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
            ->where('meta->cnaps_number', $data['meta']['cnaps_number'])
            ->first();
        }else{
            $contactExist = Contact::beneficiaries()->verified()
            ->where("workspace_id", $this->workspace_id)
            ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
            ->where('meta->ach_routing_number', $data['meta']['ach_routing_number'])
            ->first();
        }

        
        if(!is_null($contactExist))
        {
            $this->addError('meta.bank_account_number', 'The beneficiary with this account number has already been created.');
        }else{

            if($data['type'] == 'business'){
                $data['display_name'] = Helper::removeExtraSpace($data['company_name']);
                $data['type'] = 'company';
            }else{
                $data['display_name'] = Helper::removeExtraSpace(implode(' ', [$data['first_name'], $data['middle_name'], $data['last_name']]));
            }

            if(! is_null($this->avatar))
            {
                $data['avatar'] = $this->avatar->store('Images', 'azure');
            }

            $currencyDetails = [
                'sending_currency' => session('money_transfer_request.currency_code_from'),
                'receiving_currency' => session('money_transfer_request.currency_code_to'),
                'bank_code_type' => 'ifsc',
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

            $transactionOtpService = Setting::getValue('transaction_otp_service');

            if($transactionOtpService == 'email')
            {
                if (config('services.disable_email_service') == false) {
                    $contact->notify(new EmailOneTimePasswordNotification($contact->generateOtp("email")));
                }else
                {
                    $contact->generateOtp("email");
                }
            }else
            {
                if (config('services.disable_sms_service') == false) {
                    $contact->notify(new SmsOneTimePasswordNotification($contact->generateOtp("sms")));
                }else
                {
                    $contact->generateOtp("sms");
                }
            }

            $this->oneTimePassword = $this->contact->oneTimePasswords()->first()->id;

            session(['contact' => $contact, 'oneTimePassword' => $this->oneTimePassword]);

            //$user->generateOtp("sms");
            $this->beneficiary_created = true;

            $this->dispatchBrowserEvent('showOtpModel',['modalType' => $this->beneficiaryType]);
        }

    }

    public function render()
    {
        return view('international-transfer::livewire.myself-beneficiary');
    }
}
 