<?php

namespace Kanexy\InternationalTransfer\Tests;

use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Tests\TestCase;

class ExchangeRateTest extends TestCase
{
    /** @test */
    public function exchange_rate_test_success()
    {
        $result = Helper::getExchangeRate('INR','EUR',100);

        $this->assertEquals(1.21346,$result);
    }

    /** @test */
    public function exchange_rate_change_to_country_code_test_failure()
    {
        $result = Helper::getExchangeRate('INR','EURO',100);

        $this->assertEquals(NULL,$result);
    }

    /** @test */
    public function exchange_rate_change_from_country_code_test_failure()
    {
        $result = Helper::getExchangeRate('RTY','EURO',100);

        $this->assertEquals(NULL,$result);
    }

    /** @test */
    public function exchange_rate_pass_number_for_from_and_to_test_failure()
    {
        $result = Helper::getExchangeRate(52,26,20);

        $this->assertEquals(NULL,$result);
    }
}
