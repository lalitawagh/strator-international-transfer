<?php

namespace Kanexy\InternationalTransfer\Tests;

use  Kanexy\InternationalTransfer\Tests\TestCase;

class TransferTypeFeeTest extends TestCase
{
    /** @test */
    public function transfer_type_fee_create_test_success()
    {
        $response = $this->postJson(route('dashboard.international-transfer.transfer-type-fee.create'),[]);
        $response->assertTrue(200);
    }
}
