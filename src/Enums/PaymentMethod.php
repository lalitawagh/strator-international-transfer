<?php

namespace Kanexy\InternationalTransfer\Enums;

use Kanexy\Cms\Enums\Enum;

class PaymentMethod extends Enum {
    public const MANUAL_TRANSFER = 'manual_transfer';
    public const STRIPE = 'stripe';
    public const BANK_ACCOUNT = 'bank_account';
}
