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
            'type'        =>    'exchange_fees',
            'fee_type'    =>    'percentage',
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
            'type'        =>    'exchange_fees',
            'fee_type'    =>    'percentage',
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
    public function fee_create_test_min_amount_negative_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'type'        =>    'exchange_fees',
            'min_amount'  =>    -5,
            'max_amount'  =>    1000,
            'amount'      =>    1880,
            'percentage'  =>    7,
            'status'      =>    'active',
        ];
        $response = $this->postJson(route('dashboard.international-transfer.fee.store'),$data);
        $response->assertStatus(422);
    }

    /** @test */
    public function fee_create_test_max_amount_greater_than_min_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'type'        =>    'exchange_fees',
            'min_amount'  =>    5,
            'max_amount'  =>    4,
            'amount'      =>    1880,
            'percentage'  =>    7,
            'status'      =>    'active',
        ];
        $response = $this->postJson(route('dashboard.international-transfer.fee.store'),$data);
        $response->assertStatus(422);
    }

    /** @test */
    public function fee_create_test_percentage_negative_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'type'        =>    'exchange_fees',
            'min_amount'  =>    5,
            'max_amount'  =>    4,
            'amount'      =>    1880,
            'percentage'  =>    -2,
            'status'      =>    'active',
        ];
        $response = $this->postJson(route('dashboard.international-transfer.fee.store'),$data);
        $response->assertStatus(422);
    }

    /** @test */
    public function fee_create_test_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'type'        =>    'exchange_fees',
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
            'type'        =>    'exchange_fees',
            'min_amount'  =>    0,
            'amount'      =>    1880,
            'percentage'  =>    7,
            'status'      =>    'active',
        ];
        $response = $this->putJson(route('dashboard.international-transfer.fee.update','13042022114648'),$data);
        $response->assertStatus(422);
    }

}
