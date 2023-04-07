<?php

namespace Kanexy\InternationalTransfer\Enums;

use Kanexy\Cms\Enums\Enum;

class PaymentMethod extends Enum
{
    public const MANUAL_TRANSFER = 'manual_transfer';
    public const STRIPE = 'stripe';
    public const BANK_ACCOUNT = 'bank_account';
    public const TOTAL_PROCESSING = 'total_processing';

    public const ALL_PAYMENT_METHODS = [
        self::MANUAL_TRANSFER => 'manual_transfer',
        self::STRIPE => 'stripe',
        self::BANK_ACCOUNT => 'bank_account',
        self::TOTAL_PROCESSING => 'total_processing'
    ];
}
