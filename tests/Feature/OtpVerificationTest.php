<?php

namespace Kanexy\InternationalTransfer\Tests;

use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\User;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Livewire\OtpVerification;
use Kanexy\InternationalTransfer\Tests\TestCase;
use Kanexy\Banking\Models\Account;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Livewire\Livewire;

class OtpVerificationTest extends TestCase
{
    /** @test */
    public function verify_otp_test_success()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $user = User::find(2);
        $this->actingAs($user);

        $workspace = $user->workspaces()->first();
        $account = Account::forHolder($workspace)->first();
        session(['contact' => Contact::latest()->first()]);

        $response = Livewire::test(OtpVerification::class,['countries' => $countries,'defaultCountry' => $defaultCountry,'user' => $user, 'account' => $account, 'workspace' => $workspace])
        ->set('code', '494311')
        ->call('verifyOtp');

        $response->assertRedirect(route('dashboard.international-transfer.money-transfer.payment'));
    }

    /** @test */
    public function verify_otp_test_failure()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $user = User::find(2);
        $this->actingAs($user);

        $workspace = $user->workspaces()->first();
        $account = Account::forHolder($workspace)->first();
        session(['contact' => Contact::latest()->first()]);

        $response = Livewire::test(OtpVerification::class,['countries' => $countries,'defaultCountry' => $defaultCountry,'user' => $user, 'account' => $account, 'workspace' => $workspace])
        ->set('code', '494789')
        ->call('verifyOtp');

        $response->assertNoRedirect(route('dashboard.international-transfer.money-transfer.payment'));
    }
}
