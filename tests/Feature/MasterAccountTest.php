<?php

namespace Kanexy\InternationalTransfer\Tests;

use Kanexy\Cms\Models\User;
use Kanexy\InternationalTransfer\Tests\TestCase;

class MasterAccountTest extends TestCase
{
    /** @test */
    public function master_account_create_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'account_holder_name'  =>    'Krishna',
            'account_branch'       =>    'Nashik',
            'account_number'       =>    48255888,
            'sort_code'            =>   784512,
        ];
        $response = $this->postJson(route('dashboard.international-transfer.master-account.store'),$data);
        $response->assertStatus(302);
    }

    /** @test */
    public function master_account_create_test_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'account_holder_name'  =>    'Krishna',
            'account_branch'       =>    'Nashik',
            'sort_code'            =>   784512,
        ];
        $response = $this->postJson(route('dashboard.international-transfer.master-account.store'),$data);
        $response->assertStatus(422);
    }

    /** @test */
    public function master_account_number_as_string_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'account_holder_name'  =>    'Krishna',
            'account_branch'       =>    'Nashik',
            'account_number'       =>    'XXXX',
            'sort_code'            =>   784512,
        ];
        $response = $this->postJson(route('dashboard.international-transfer.master-account.store'),$data);
        $response->assertStatus(422);
    }

    /** @test */
    public function master_sort_code_as_string_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'account_holder_name'  =>    'Krishna',
            'account_branch'       =>    'Nashik',
            'account_number'       =>    78451212,
            'sort_code'            =>   'ZZZ',
        ];
        $response = $this->postJson(route('dashboard.international-transfer.master-account.store'),$data);
        $response->assertStatus(422);
    }

    /** @test */
    public function master_sort_code_contain_six_digit_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'account_holder_name'  =>    'Krishna',
            'account_branch'       =>    'Nashik',
            'account_number'       =>    78451212,
            'sort_code'            =>   78451212,
        ];
        $response = $this->postJson(route('dashboard.international-transfer.master-account.store'),$data);
        $response->assertStatus(422);
    }

    /** @test */
    public function master_account_number_contain_eight_digit_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'account_holder_name'  =>    'Krishna',
            'account_branch'       =>    'Nashik',
            'account_number'       =>    78451212888,
            'sort_code'            =>   78451212,
        ];
        $response = $this->postJson(route('dashboard.international-transfer.master-account.store'),$data);
        $response->assertStatus(422);
    }

}
