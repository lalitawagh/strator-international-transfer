<?php

namespace Kanexy\InternationalTransfer\Tests;

use Kanexy\Cms\Models\User;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Tests\TestCase;

class PaymentTest extends TestCase
{

    /** @test */
    public function bank_payment_test_success()
    {
        $this->app['config']->set('partner-foundation.wrappex_dev_url', 'https://dev.wrappex.com/');
        $this->token = Setting::getValue('wrappex_access_token');

        $user = User::find(42);

        $this->actingAs($user);

        $paymentData = [
            'currency_code_from' => '231',
            'currency_code_to' => '1',
            'amount' => 0.02,
            'fee_charge' => 0.20,
            'guaranteed_rate' => 1.13,
            'recipient_amount' => 7.89,
            'workspace_id' => 102,
            'beneficiary_id' => 266,
        ];

        $this->session(['money_transfer_request' => $paymentData]);

        $data = [
            'transfer_reason'      =>   'family',
            'payment_method'      =>    'bank_account',
        ];

        $response = $this->postJson(route('dashboard.international-transfer.money-transfer.transactionDetail'),$data);
        $response->assertStatus(302);

        $responseSecond = $this->getJson(route('dashboard.international-transfer.money-transfer.final'));
        $responseSecond->assertStatus(302);

        $transaction = session('money_transfer_request.transaction');

        $responseThird = $this->getJson(route('dashboard.international-transfer.money-transfer.verify',['id' =>$transaction->id]));
        $responseThird->assertStatus(302);
    }


    /** @test */
    public function manual_payment_test_success()
    {
        $this->app['config']->set('partner-foundation.wrappex_dev_url', 'https://dev.wrappex.com/');
        $this->token = Setting::getValue('wrappex_access_token');

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
            'beneficiary_id' => 266,
        ];

        $this->session(['money_transfer_request' => $paymentData]);

        $data = [
            'transfer_reason'      =>   'family',
            'payment_method'      =>    'manual_transfer',
        ];

        $response = $this->postJson(route('dashboard.international-transfer.money-transfer.transactionDetail'),$data);
        $response->assertStatus(302);

        $responseSecond = $this->getJson(route('dashboard.international-transfer.money-transfer.final'));
        $responseSecond->assertStatus(302);
    }

    /** @test */
    public function stripe_payment_test_success()
    {
        $this->app['config']->set('partner-foundation.wrappex_dev_url', 'https://dev.wrappex.com/');
        $this->app['config']->set('services.stripe.secret', 'sk_test_51IDCdlCedkQGNQblNSCU5FzboJ2Ya4G09aK3FgV20Q6ooxuXMJk7j9mu4aE1WrPsBSh1vaKoS2bX0Fkk9C8xMhAK00kwwzzc8v');
        $this->token = Setting::getValue('wrappex_access_token');

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $data = \Stripe\Token::create([
            'card' => [
                "number" => "4242424242424242",
                "exp_month" => 11,
                "exp_year" => 2025,
                "cvc" => "314"
            ]
        ]);

        $this->stripeToken = $data['id'];


        $user = User::find(42);

        $this->actingAs($user);

        $paymentData = [
            'currency_code_from' => '231',
            'currency_code_to' => '1',
            'amount' => 100,
            'fee_charge' => 10,
            'guaranteed_rate' => 1.13,
            'recipient_amount' => 7.89,
            'workspace_id' => 103,
            'beneficiary_id' => 266
        ];

        $this->session(['money_transfer_request' => $paymentData]);

        $data = [
            'amount' => 100,
            'transfer_reason'      =>   'family',
            'payment_method'      =>    'stripe',
            'stripeToken' => $this->stripeToken
        ];

        $response = $this->postJson(route('dashboard.international-transfer.money-transfer.transactionDetail'),$data);
        $response->assertStatus(302);

        $responseSecond = $this->postJson(route('dashboard.international-transfer.money-transfer.stripeInitialize'),$data);
        $responseSecond->assertStatus(200);

        $stripeResponse = $responseSecond['data'];

        $responseThird = $this->postJson(route('dashboard.international-transfer.money-transfer.stripePayment'),['data' => $stripeResponse]);
        $responseThird->assertStatus(200);

    }

    /** @test */
    public function bank_payment_test_failure()
    {
        $this->app['config']->set('partner-foundation.wrappex_dev_url', 'https://dev.wrappex.com/');
        $this->token = Setting::getValue('wrappex_access_token');

        $user = User::find(42);

        $this->actingAs($user);

        $paymentData = [
            'currency_code_from' => '231',
            'currency_code_to' => '1',
            'amount' => 0.20,
            'fee_charge' => 0.20,
            'guaranteed_rate' => 1.13,
            'recipient_amount' => 7.89,
            'workspace_id' => 102,
        ];

        $this->session(['money_transfer_request' => $paymentData]);

        $data = [
            'payment_method'      =>    'bank_account',
        ];

        $response = $this->postJson(route('dashboard.international-transfer.money-transfer.transactionDetail'),$data);
        $response->assertStatus(422);

        $responseSecond = $this->getJson(route('dashboard.international-transfer.money-transfer.final'));
        $responseSecond->assertStatus(500);

        $transaction = session('money_transfer_request.transaction');

        $responseThird = $this->getJson(route('dashboard.international-transfer.money-transfer.verify',['id' =>$transaction?->id]));
        $responseThird->assertStatus(500);
    }


    /** @test */
    public function manual_payment_test_failure()
    {
        $this->app['config']->set('partner-foundation.wrappex_dev_url', 'https://dev.wrappex.com/');
        $this->token = Setting::getValue('wrappex_access_token');

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
            'payment_method'      =>    'manual_transfer',
        ];

        $response = $this->postJson(route('dashboard.international-transfer.money-transfer.transactionDetail'),$data);
        $response->assertStatus(500);

        $responseSecond = $this->getJson(route('dashboard.international-transfer.money-transfer.final'));
        $responseSecond->assertStatus(500);
    }

    /** @test */
    public function stripe_payment_test_failure()
    {
        $this->app['config']->set('partner-foundation.wrappex_dev_url', 'https://dev.wrappex.com/');
        $this->app['config']->set('services.stripe.secret', 'sk_test_51IDCdlCedkQGNQblNSCU5FzboJ2Ya4G09aK3FgV20Q6ooxuXMJk7j9mu4aE1WrPsBSh1vaKoS2bX0Fkk9C8xMhAK00kwwzzc8v');
        $this->token = Setting::getValue('wrappex_access_token');

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $data = \Stripe\Token::create([
            'card' => [
                "number" => "4242424242424242",
                "exp_month" => 11,
                "exp_year" => 2025,
                "cvc" => "314"
            ]
        ]);

        $this->stripeToken = $data['id'];


        $user = User::find(42);

        $this->actingAs($user);

        $paymentData = [
            'currency_code_from' => '231',
            'currency_code_to' => '1',
            'amount' => 100,
            'fee_charge' => 10,
            'guaranteed_rate' => 1.13,
            'recipient_amount' => 7.89,
            'workspace_id' => 103,
        ];

        $this->session(['money_transfer_request' => $paymentData]);

        $data = [
            'transfer_reason'      =>   'family',
            'payment_method'      =>    'stripe',
            'stripeToken' => $this->stripeToken
        ];

        $response = $this->postJson(route('dashboard.international-transfer.money-transfer.transactionDetail'),$data);
        $response->assertStatus(500);

        $responseSecond = $this->postJson(route('dashboard.international-transfer.money-transfer.stripeInitialize'),$data);
        $responseSecond->assertStatus(500);

        $stripeResponse = $responseSecond['data'] ?? null;

        $responseThird = $this->postJson(route('dashboard.international-transfer.money-transfer.stripePayment'),['data' => $stripeResponse]);
        $responseThird->assertStatus(500);

    }

}
