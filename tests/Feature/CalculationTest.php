<?php

namespace Kanexy\InternationalTransfer\Tests;

use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Livewire\InitialProcess;
use Kanexy\InternationalTransfer\Tests\TestCase;
use Livewire\Livewire;

class CalculationTest extends TestCase
{
    /** @test */
    public function actual_amount_test_success()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $response = Livewire::test(InitialProcess::class,['countries' => $countries,'defaultCountry' => $defaultCountry])
        ->call('changeAmount',10);
        $response->assertSet('actual_amount', 10);
    }

    /** @test */
    public function guaranteed_rate_test_success()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $response = Livewire::test(InitialProcess::class,['countries' => $countries,'defaultCountry' => $defaultCountry,'currency_from' => 1, 'currency_to' => 231])
        ->call('changeAmount',10);
        $response->assertSet('guaranteed_rate', 0.840288);
    }

    /** @test */
    public function guaranteed_rate_test_failure()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $response = Livewire::test(InitialProcess::class,['countries' => $countries,'defaultCountry' => $defaultCountry,'currency_from' => 1, 'currency_to' => 231])
        ->call('changeAmount',10);
        $response->assertNotSet('guaranteed_rate', 0.840);
    }

    /** @test */
    public function disabled_selected_country_dispatch_browser_event_test_success()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $response = Livewire::test(InitialProcess::class,['countries' => $countries,'defaultCountry' => $defaultCountry,'currency_from' => 1, 'currency_to' => 231])
        ->call('changeFromCurrency',231);
        $response->assertDispatchedBrowserEvent('disabledSelectedCountry', ['currency' => 231]);
    }

    /** @test */
    public function tail_select_browser_event_test_success()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $response = Livewire::test(InitialProcess::class,['countries' => $countries,'defaultCountry' => $defaultCountry,'currency_from' => 1, 'currency_to' => 231])
        ->call('changeFromCurrency',231);
        $response->assertDispatchedBrowserEvent('UpdateLivewireSelect');
    }

    /** @test */
    public function final_amount_test_success()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $response = Livewire::test(InitialProcess::class,['countries' => $countries,'defaultCountry' => $defaultCountry,'actual_amount' => 150, 'guaranteed_rate' => 0.840288])
        ->call('changeToMethod',10);
        $response->assertSet('recipient_amount',117.64032);
    }

    /** @test */
    public function final_amount_test_failure()
    {
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $response = Livewire::test(InitialProcess::class,['countries' => $countries,'defaultCountry' => $defaultCountry,'actual_amount' => 150, 'guaranteed_rate' => 0.840288])
        ->call('changeToMethod',10);
        $response->assertNotSet('recipient_amount',2025.64032);
    }


}
