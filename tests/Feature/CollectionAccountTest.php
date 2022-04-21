<?php

namespace Kanexy\InternationalTransfer\Tests;

use Illuminate\Foundation\Auth\User;
use Kanexy\InternationalTransfer\Tests\TestCase;

class CollectionAccountTest extends TestCase
{
    /** @test */
    public function collection_account_create_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'account_holder_name'  =>    'Krishna',
            'account_branch'       =>    'Nashik',
            'account_number'       =>    48255888,
            'sort_code'            =>   784512,
        ];
        $response = $this->postJson(route('dashboard.international-transfer.collection-account.store'),$data);
        $response->assertStatus(302);
    }


    public function collection_account_create_test_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'account_holder_name'  =>    'Krishna',
            'account_branch'       =>    'Nashik',
            'sort_code'            =>   784512,
        ];
        $response = $this->postJson(route('dashboard.international-transfer.collection-account.store'),$data);
        $response->assertStatus(422);
    }

}
