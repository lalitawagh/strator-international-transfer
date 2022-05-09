<?php

namespace Kanexy\InternationalTransfer\Tests;

use Kanexy\Cms\Models\User;
use Kanexy\InternationalTransfer\Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    public function payment_test_success()
    {
        $user = User::find(42);

        $this->actingAs($user);

        $paymentData = [
            'currency_code_from' => '231',
            'currency_code_to' => '1',
            'amount' => 10,
            'fee_charge' => 0.20,
            'guaranteed_rate' => 1.13,
            'recipient_amount' => 7.89,
            'workspace_id' => 103,
            'beneficiary_id' => 266
        ];

        $this->session(['money_transfer_request' => $paymentData]);

        $data = [
            'transfer_reason'      =>   'family',
            'payment_method'      =>    'manually_transfer',
        ];

        $response = $this->postJson(route('dashboard.international-transfer.money-transfer.transactionDetail'),$data);
        $response->assertStatus(302);
    }

    /** @test */
    public function payment_test_failure()
    {
        $user = User::find(42);

        $this->actingAs($user);

        $paymentData = [
            'currency_code_from' => '231',
            'currency_code_to' => '1',
            'amount' => 10,
            'fee_charge' => 0.20,
            'guaranteed_rate' => 1.13,
            'recipient_amount' => 7.89,
            'workspace_id' => 103,
        ];

        $this->session(['money_transfer_request' => $paymentData]);

        $data = [
            'transfer_reason'      =>   'family',
            'payment_method'      =>    'manually_transfer',
        ];

        $response = $this->postJson(route('dashboard.international-transfer.money-transfer.transactionDetail'),$data);
        $response->assertStatus(500);
    }

}
