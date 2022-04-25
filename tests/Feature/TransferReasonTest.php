<?php

namespace Kanexy\InternationalTransfer\Tests;

use Kanexy\Cms\Models\User;
use Kanexy\InternationalTransfer\Tests\TestCase;

class TransferReasonTest extends TestCase
{
    /** @test */
    public function transfer_reason_create_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'reason'      =>    'family',
            'status'      =>    'active',
        ];
        $response = $this->postJson(route('dashboard.international-transfer.transfer-reason.store'),$data);
        $response->assertStatus(302);
    }

    /** @test */
    public function transfer_reason_update_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'reason'      =>    'familyRDDD',
            'status'      =>    'active',
        ];
        $response = $this->putJson(route('dashboard.international-transfer.transfer-reason.update','21042022135956'),$data);
        $response->assertStatus(302);
    }

    /** @test */
    public function transfer_reason_delete_test_success()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $response = $this->delete(route('dashboard.international-transfer.transfer-reason.destroy','21042022141338'));
        $response->assertStatus(302);
    }

    /** @test */
    public function transfer_reason_create_test_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'reason'      =>    88,
            'status'      =>    'active',
        ];
        $response = $this->postJson(route('dashboard.international-transfer.transfer-reason.store'),$data);
        $response->assertStatus(422);
    }

    /** @test */
    public function transfer_reason_update_test_failure()
    {
        $user = User::find(1);

        $this->actingAs($user);

        $data = [
            'reason'      =>    88,
            'status'      =>    'active',
        ];
        $response = $this->putJson(route('dashboard.international-transfer.transfer-reason.update','13042022114648'),$data);
        $response->assertStatus(422);
    }

}
