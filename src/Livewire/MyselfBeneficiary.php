<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Kanexy\Cms\Helper;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Notifications\EmailOneTimePasswordNotification;
use Kanexy\Cms\Notifications\SmsOneTimePasswordNotification;
use Kanexy\Cms\Rules\AlphaSpaces;
use Kanexy\Cms\Rules\LandlineNumber;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\CurrencyCloud\Dtos\ValidateBeneficiaryDto;
use Kanexy\CurrencyCloud\Services\CurrencyCloudApiService;
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

    public $receivedCountry;

    protected function rules()
    {
        $rules = [
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
            'meta.bank_account_name' => ['required', new AlphaSpaces,'max:40'],
            'meta.bank_account_number' => ['string', 'numeric'],
            'meta.bank_code' => ['nullable', 'string', 'numeric', 'digits:6'],
            'company_name'   => ['required_if:type,business', 'nullable', new AlphaSpaces, 'string','max:40'],
            'meta.branch_code' => ['nullable', 'string', 'numeric', 'digits:6'],
            'meta.iban_number' => ['string'],
            'meta.post_code' => ['regex:/^(?:[A-Z]{2}\d{2}[A-Z0-9]{1,30}|)$/i'],
            //'meta.ach_routing_number' => ['required_if:receiving_country,==,' . ShortCode::SHORT_CODE[ShortCode::AI][0]],
        ];

        if (in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::AASP])) {
            $rules['meta.aba_number'] = 'required';
            $rules['meta.benficiary_state'] = 'required';
            $rules['meta.post_code'] = 'required';
            $rules['meta.bank_account_number'] = 'required';
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::BBSP]))
        {
            $rules['meta.bank_code'] = 'required';
            $rules['meta.benficiary_state'] = 'required';
            $rules['meta.post_code'] = 'required';
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::AI]))
        {
            $rules['meta.iban_number'] = 'required|string';
            $rules['meta.bank_account_number'] = 'required|numeric';
            if($this->receiving_country != 'IN')
            {
                $rules['meta.bic_number'] = 'required';
            }

        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::SA]))
        {
            $rules['meta.bank_code'] = 'required|numeric|digits:6';
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::BAP]))
        {
            $rules['meta.post_code'] = 'required';
            $rules['meta.bsb_number'] = 'required';
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::BCSP]))
        {

            $rules['meta.bic_number'] = 'required';
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::CB]))
        {
            $rules['meta.cnaps_number'] = 'required';
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::BIA]))
        {
            $rules['meta.bic_number'] = 'required';
            $rules['meta.bank_account_number'] = 'required';
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::BBA]))
        {
            $rules['meta.bank_code'] = 'required';
            $rules['meta.bank_account_number'] = 'required';
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::IB]))
        {
            $rules['meta.iban_number'] = 'required';
            $rules['meta.bank_account_number'] = 'required';
            if($this->receiving_country != 'IN')
            {
                $rules['meta.bic_number'] = 'required';
            }
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::BA]))
        {
            $rules['meta.bank_code'] = 'required';
            $rules['meta.bank_account_number'] = 'required';
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::I]))
        {
            $rules['meta.iban_number'] = 'required';
            if($this->receiving_country != 'IN')
            {
                $rules['meta.bic_number'] = 'required';
            }
        }

        if(in_array($this->receiving_country, ShortCode::SHORT_CODE[ShortCode::BASP]))
        {

            $rules['meta.bic_number'] = 'required';
        }

        return $rules;
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
        'meta.benficiary_state' => 'State',
        'meta.benficiary_city' => 'City',
        'meta.branch_code' => 'Branch Code',
        'meta.post_code' => 'Post Code',
        'meta.ach_routing_number' => 'ACH Routing Number',
        'meta.bsb_number' => 'BSB Number',
        'meta.aba_number' => 'ABA Number',
        'meta.bic_number' => 'BIC Number',
        'meta.cnaps_number' => 'CNAPS Number',
    ];

    protected function messages()
    {
        return  [
            'meta.bank_account_name.regex' =>'Account Name contains Letters and Spaces Only.',
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
        $this->receivedCountry = Country::find(session('money_transfer_request.currency_code_to'))->name;
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

        $this->benficiaryCreate($data);
    }

    public function benficiaryCreate($data)
    {

            $routing_type = 'sort_code';

            if(isset($data['meta']['bank_code']))
            {
                $contactExist = Contact::beneficiaries()->verified()
                ->where("workspace_id", $this->workspace_id)
                ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
                ->where('meta->bank_code', $data['meta']['bank_code'])
                ->first();
                if($this->receiving_country == 'IN')
                {
                    $routing_type = 'ifsc';
                }elseif($this->receiving_country == 'GB')
                {
                    $routing_type = 'sort_code';
                }else{
                    $routing_type = 'bank_code';
                }

                $routing_code_value = ($this->receiving_country == 'IN') ? $data['meta']['iban_number'] : $data['meta']['bank_code'];

            }elseif (isset($data['meta']['iban_number'])){
                if($this->receiving_country == 'IN')
                {
                    $contactExist = Contact::beneficiaries()->verified()
                    ->where("workspace_id", $this->workspace_id)
                    ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
                    ->where('meta->iban_number', $data['meta']['iban_number'])
                    ->first();
                }else
                {
                    $contactExist = Contact::beneficiaries()->verified()
                    ->where("workspace_id", $this->workspace_id)
                    ->where('meta->iban_number', $data['meta']['iban_number'])
                    ->first();
                }

                $routing_type = ($this->receiving_country == 'IN') ? 'ifsc' : 'iban';
                $routing_code_value = ($this->receiving_country == 'IN') ? $data['meta']['iban_number'] : $data['meta']['iban_number'];


            }elseif (isset($data['meta']['bsb_number'])){
                $contactExist = Contact::beneficiaries()->verified()
                ->where("workspace_id", $this->workspace_id)
                ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
                ->where('meta->bsb_number', $data['meta']['bsb_number'])
                ->first();

                $routing_type = 'bsb_code';
                $routing_code_value =  $data['meta']['bsb_number'];

            }elseif (isset($data['meta']['aba_number'])){
                $contactExist = Contact::beneficiaries()->verified()
                ->where("workspace_id", $this->workspace_id)
                ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
                ->where('meta->aba_number', $data['meta']['aba_number'])
                ->first();

                $routing_type = 'aba';
                $routing_code_value =  $data['meta']['aba_number'];

            }elseif (isset($data['meta']['bic_number'])){
                $contactExist = Contact::beneficiaries()->verified()
                ->where("workspace_id", $this->workspace_id)
                ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
                ->where('meta->bic_number', $data['meta']['bic_number'])
                ->first();

                $routing_type = 'bank_code';
                $routing_code_value =  $data['meta']['bic_number'];

            }elseif (isset($data['meta']['cnaps_number'])){
                $contactExist = Contact::beneficiaries()->verified()
                ->where("workspace_id", $this->workspace_id)
                ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
                ->where('meta->cnaps_number', $data['meta']['cnaps_number'])
                ->first();

                $routing_type = 'cnaps';
                $routing_code_value =  $data['meta']['cnaps_number'];

        }else{
            $contactExist = Contact::beneficiaries()->verified()
            ->where("workspace_id", $this->workspace_id)
            ->where('meta->bank_account_number', $data['meta']['bank_account_number'])
            ->where('meta->ach_routing_number', $data['meta']['ach_routing_number'])
            ->first();

            $routing_type = 'bank_code';
            $routing_code_value =  $data['meta']['ach_routing_number'];
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
                    'bank_code_type' => $routing_type,
                    'bank_country' => session('money_transfer_request.currency_code_to') ? session('money_transfer_request.currency_code_to')  : $this->country,
                    'cc_routing_code_value' => $routing_code_value,
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

                $service = new CurrencyCloudApiService;
                $validateBeneficiary = $service->validateBeneficaries(new ValidateBeneficiaryDto($data));

                if ($validateBeneficiary['code'] == 200)
                {
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
                else {
                    return redirect()->route('dashboard.international-transfer.money-transfer.beneficiary', ['filter' => ['workspace_id' => app('activeWorkspaceId')]])->with(['status' => 'failed', 'message' => $validateBeneficiary['message']]);
                }
            }
    }

    public function render()
    {
        return view('international-transfer::livewire.myself-beneficiary');
    }
}
