<?php

namespace Kanexy\InternationalTransfer\Tests;

use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\User;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Enums\Beneficiary;
use Kanexy\InternationalTransfer\Livewire\MyselfBeneficiary;
use Kanexy\InternationalTransfer\Tests\TestCase;
use Kanexy\PartnerFoundation\Banking\Models\Account;
use Livewire\Livewire;

class BeneficiaryTest extends TestCase
{
    /** @test */
    public function create_beneficiary_test_success()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $user = User::find(2);
        $this->actingAs($user);

        $workspace = $user->workspaces()->first();
        $account = Account::forHolder($workspace)->first();
        $beneficiaryType = Beneficiary::MYSELF;

        $data = [
            'swift_code' => '254163',
            'iban_number' => 'AERP78452A',
            'bank_account_name' => 'Lalita',
            'account_number' => '78451245',
            'sort_no' => '784512',
        ];

        $response = Livewire::test(MyselfBeneficiary::class,['countries' => $countries,'defaultCountry' => $defaultCountry,'user' => $user, 'account' => $account, 'workspace' => $workspace, 'beneficiaryType' => $beneficiaryType])
        ->set('first_name', 'lalita')
        ->set('last_name', 'wagh')
        ->set('email', 'lalitawagh28@gmail.com')
        ->set('mobile', '7845127845')
        ->set('meta', $data)
        ->set('type', 'personal')
        ->call('createBeneficiary');

        $response->assertSet('beneficiary_created', true);
    }

    /** @test */
    public function create_beneficiary_test_failure()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $user = User::find(2);
        $this->actingAs($user);

        $workspace = $user->workspaces()->first();
        $account = Account::forHolder($workspace)->first();
        $beneficiaryType = Beneficiary::MYSELF;

        $data = [
            'swift_code' => '254163',
            'iban_number' => 'AERP78452A',
            'bank_account_name' => 'Lalita',
            'account_number' => '7845124578',
            'sort_no' => '78451278',
        ];

        $response = Livewire::test(MyselfBeneficiary::class,['countries' => $countries,'defaultCountry' => $defaultCountry,'user' => $user, 'account' => $account, 'workspace' => $workspace, 'beneficiaryType' => $beneficiaryType])
        ->set('first_name', 'lalita')
        ->set('last_name', 'wagh')
        ->set('email', 'lalitawagh28@gmail.com')
        ->set('mobile', '7845127845')
        ->set('meta', $data)
        ->set('type', 'personal')
        ->call('createBeneficiary');

        $response->assertSet('beneficiary_created', false);
    }
}
