<?php

use Kanexy\InternationalTransfer\Enums\PaymentMethod;

/*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */



$data =  [
    [
        'method' => PaymentMethod::BANK_ACCOUNT,
        'title' => 'Transfer from ' . config('app.name') . ' Bank Balance',
        'heading' => 'Transfer through ' . config('app.name') . '  account',
        'description' => 'Easy and faster payment made through your ' . config('app.name') . ' account.',
        'image' => asset('dist/images/Yzer-Bank.png'),
    ],
    [
        'method' => PaymentMethod::MANUAL_TRANSFER,
        'title' => 'Manual Transfer',
        'heading' => 'Bank charges will be applied for manual payment',
        'description' => 'Easily transfer manual through reference number.',
        'image' => asset('dist/images/Manually-Transfer.png'),
    ],
    [
        'method' => PaymentMethod::STRIPE,
        'title' => 'Stripe',
        'heading' => 'Stripe charges will be applied',
        'description' => 'Easy and faster stripe payment.',
        'image' => asset('dist/images/CardPay-Debit.png'),
    ],
];

return $data;


