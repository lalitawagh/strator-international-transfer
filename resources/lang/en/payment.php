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
        'title' => 'Transfer from ' . config('app.name') . ' bank Balance',
        'heading' => 'Transfer through ' . config('app.name') . '  account',
        'description' => 'This payment is made through your ' . config('app.name') . ' account.',
        'image' => asset('dist/images/Yzer-Bank.png'),
    ],
    [
        'method' => PaymentMethod::MANUAL_TRANSFER,
        'title' => 'Manual Transfer',
        'heading' => 'Bank charges will be applied for manual payment',
        'description' => 'This payment can be made from any of your other bank accounts to the given account details to process the transaction.',
        'image' => asset('dist/images/Manually-Transfer.png'),
    ],

    [
        'method' => PaymentMethod::TOTAL_PROCESSING,
        'title' => 'Total Processing',
        'heading' => 'Total charges will be applied',
        'description' => 'This payment can be made through a card. Total Processing charges are applied.',
        'image' => asset('dist/images/CardPay-Debit.png'),
    ],

];

// [
//     'method' => PaymentMethod::STRIPE,
//     'title' => 'Stripe',
//     'heading' => 'Stripe charges will be applied',
//     'description' => 'This payment can be made through a card. Stripe charges are applied.',
//     'image' => asset('dist/images/CardPay-Debit.png'),
// ],
return $data;
