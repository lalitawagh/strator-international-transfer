<?php

namespace Kanexy\InternationalTransfer\Tests;

use Kanexy\Cms\Models\User;
use Kanexy\InternationalTransfer\Tests\TestCase;

class TransferTypeFeeTest extends TestCase
{
    /** @test */
    public function transfer_type_fee_create_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'currency'    =>    '231',
            'type'        =>    'payment_type',
            'payment_type'=>    'paypal',
            'min_amount'  =>    0,
            'max_amount'  =>    1000,
            'amount'      =>   1880,
            'percentage'  =>    7,
            'status'      =>    'active',
            'description' =>    'xyz',
        ];
        $response = $this->postJson(route('dashboard.international-transfer.transfer-type-fee.store'),$data);
        $response->assertStatus(302);
    }

    /** @test */
    public function transfer_type_fee_update_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'currency'    =>    '231',
            'type'        =>    'payment_type',
            'payment_type'=>    'paypal',
            'min_amount'  =>    0,
            'max_amount'  =>    1000,
            'amount'      =>   1880,
            'percentage'  =>    7,
            'status'      =>    'active',
            'description' =>    'xyz',
        ];
        $response = $this->putJson(route('dashboard.international-transfer.transfer-type-fee.update','13042022114648'),$data);
        $response->assertStatus(302);
    }

    /** @test */
    public function transfer_type_fee_delete_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $response = $this->delete(route('dashboard.international-transfer.transfer-type-fee.destroy','13042022114907'));
        $response->assertStatus(302);
    }

    /** @test */
    public function transfer_type_fee_create_test_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'currency'    =>    '231',
            'type'        =>    'payment_type',
            'payment_type'=>    'paypal',
            'type'        =>    'fff',
            'max_amount'  =>    1000,
            'amount'      =>   1880,
            'percentage'  =>    7,
            'status'      =>    'active',
            'description' =>    'xyz',
        ];
        $response = $this->postJson(route('dashboard.international-transfer.transfer-type-fee.store'),$data);
        $response->assertStatus(422);
    }

    /** @test */
    public function transfer_type_fee_update_test_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'currency'    =>    '231',
            'type'        =>    'payment_type',
            'payment_type'=>    'paypal',
            'type'        =>    'fff',
            'max_amount'  =>    1000,
            'amount'      =>   1880,
            'percentage'  =>    7,
            'status'      =>    'active',
            'description' =>    'xyz',
        ];
        $response = $this->putJson(route('dashboard.international-transfer.transfer-type-fee.update','13042022114648'),$data);
        $response->assertStatus(422);
    }

}
