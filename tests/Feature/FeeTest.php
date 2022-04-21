<?php

namespace Kanexy\InternationalTransfer\Tests;

use Kanexy\Cms\Models\User;
use Kanexy\InternationalTransfer\Tests\TestCase;

class FeeTest extends TestCase
{
    /** @test */
    public function fee_create_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'type'        =>    'transfer_type',
            'payment_type'=>    'paypal',
            'min_amount'  =>    0,
            'max_amount'  =>    1000,
            'amount'      =>    1880,
            'percentage'  =>    7,
            'status'      =>    'active',
        ];
        $response = $this->postJson(route('dashboard.international-transfer.fee.store'),$data);
        $response->assertStatus(302);
    }

    /** @test */
    public function fee_update_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'type'        =>    'transfer_type',
            'payment_type'=>    'stripe',
            'min_amount'  =>    0,
            'max_amount'  =>    1000,
            'amount'      =>    1880,
            'percentage'  =>    7,
            'status'      =>    'active',
        ];
        $response = $this->putJson(route('dashboard.international-transfer.fee.update','21042022041717'),$data);
        $response->assertStatus(302);
    }

    /** @test */
    public function fee_delete_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $response = $this->delete(route('dashboard.international-transfer.fee.destroy','21042022044216'));
        $response->assertStatus(302);
    }

    /** @test */
    public function fee_create_test_failure()
    {
        $user = User::find(1);

        $xx = $this->actingAs($user);

        $data = [
            'type'        =>    'transfer_type',
            'payment_type'=>    'stripe',
            'min_amount'  =>    0,
            'amount'      =>    1880,
            'percentage'  =>    7,
            'status'      =>    'active',
        ];
        $response = $this->postJson(route('dashboard.international-transfer.fee.store'),$data);
        $response->assertStatus(422);
    }

    /** @test */
    public function fee_update_test_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'type'        =>    'transfer_type',
            'payment_type'=>    'stripe',
            'min_amount'  =>    0,
            'amount'      =>    1880,
            'percentage'  =>    7,
            'status'      =>    'active',
        ];

        $response = $this->putJson(route('dashboard.international-transfer.fee.update','13042022114648'),$data);
        $response->assertStatus(422);
    }

}
