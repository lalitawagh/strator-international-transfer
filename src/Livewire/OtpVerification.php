<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Carbon\Carbon;
use Kanexy\Cms\Models\OneTimePassword;
use Kanexy\Cms\Notifications\SmsOneTimePasswordNotification;
use Livewire\Component;

class OtpVerification extends Component
{
    public $countries;

    public $defaultCountry;

    public $user;

    public $account;

    public $workspace;

    public $mobile;

    public $code;

    public $oneTimePassword;

    public $sent_resend_otp;

    public function mount($countries, $defaultCountry, $user, $account, $workspace)
    {
        $this->countries = $countries;
        $this->defaultCountry = $defaultCountry;
        $this->user = $user;
        $this->account = $account;
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

        $oneTimePassword->holder->notify(new SmsOneTimePasswordNotification($oneTimePassword));

        $this->sent_resend_otp = true;
    }

    public function verifyOtp()
    {

        $data = $this->validate([
                'code' => 'required',
            ]);

        $this->contact = session('contact');

        $oneTimePassword = $this->contact->oneTimePasswords()->first();

        if ($oneTimePassword->code !== $data['code']) {
            $this->addError('code', 'The otp you entered did not match.');
        } else if (now()->greaterThan($oneTimePassword->expires_at)) {
            $this->addError('code', 'The otp you entered has expired.');
        }else{
            $oneTimePassword->update(['verified_at' => now()]);

            return redirect()->route('dashboard.international-transfer.money-transfer.payment')->with([
                'status' => 'success',
                'message' => 'The beneficiary created successfully.',
            ]);
        }
    }

    public function render()
    {
        return view('international-transfer::livewire.otp-verification');
    }
}
