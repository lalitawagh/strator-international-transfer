<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Carbon\Carbon;
use Kanexy\Cms\Models\OneTimePassword;
use Kanexy\Cms\Notifications\EmailOneTimePasswordNotification;
use Kanexy\Cms\Notifications\SmsOneTimePasswordNotification;
use Kanexy\Cms\Setting\Models\Setting;
use Livewire\Component;

class OtpVerification extends Component
{
    public $countries;

    public $defaultCountry;

    public $user;

    public $workspace;

    public $mobile;

    public $code;

    public $oneTimePassword;

    public $sent_resend_otp;

    public function mount($countries, $defaultCountry, $user, $workspace)
    {
        $this->countries = $countries;
        $this->defaultCountry = $defaultCountry;
        $this->user = $user;
        $this->workspace_id = $workspace->id;
        $this->mobile = $user->phone;
    }
    public function oneTimePassword($otp)
    {
        $this->oneTimePassword = $otp;
    }

    public function resendOtp()
    {
        $oneTimePassword = OneTimePassword::find(session('oneTimePassword'));
        if (Carbon::now()->gt($oneTimePassword->expires_at) && $oneTimePassword->verified_at == null) {

            $oneTimePassword->update(['code' => rand(100000, 999999), 'expires_at' => now()->addMinutes(OneTimePassword::getExpiringDuration())]);
        }

        $transactionOtpService = Setting::getValue('transaction_otp_service');

        if($transactionOtpService == 'email')
        {
            if (config('services.disable_email_service') == false) {
                $oneTimePassword->holder->notify(new EmailOneTimePasswordNotification($oneTimePassword));
            }else
            {
                $oneTimePassword->holder->generateOtp("email");
            }
        }else
        {
            if (config('services.disable_sms_service') == false) {
                $oneTimePassword->holder->notify(new SmsOneTimePasswordNotification($oneTimePassword));
            }else
            {
                $oneTimePassword->holder->generateOtp("sms");
            }
        }

        $this->sent_resend_otp = true;
    }

    public function verifyOtp()
    {

        $data = $this->validate([
                'code' => 'required',
            ]);

        $this->contact = session('contact');

        $oneTimePassword = $this->contact->oneTimePasswords()->first();
        $manualOtp = Setting::getValue('otp');

        if (isset($manualOtp) && ($manualOtp == $data['code'])) {
            $oneTimePassword->update(['verified_at' => now()]);

            $requestTransfer = session('money_transfer_request');
            $requestTransfer['beneficiary_id'] = $this->contact->id;

            session(['money_transfer_request' => $requestTransfer]);

            return redirect()->route('dashboard.international-transfer.money-transfer.payment',['filter' => ['workspace_id' => $this->workspace_id]])->with([
                'status' => 'success',
                'message' => 'The beneficiary created successfully.',
            ]);
        }

        if ($oneTimePassword->code !== $data['code']) {
            $this->addError('code', 'The otp you entered did not match.');
        } else if (now()->greaterThan($oneTimePassword->expires_at)) {
            $this->addError('code', 'The otp you entered has expired.');
        }else{
            $oneTimePassword->update(['verified_at' => now()]);

            $requestTransfer = session('money_transfer_request');
            $requestTransfer['beneficiary_id'] = $this->contact->id;

            session(['money_transfer_request' => $requestTransfer]);

            return redirect()->route('dashboard.international-transfer.money-transfer.payment',['filter' => ['workspace_id' => $this->workspace_id]])->with([
                'status' => 'success',
                'message' => 'The beneficiary created successfully.',
            ]);
        }

    }

    public function render()
    {
        return view('international-transfer::livewire.otp-verification-component');
    }
}
