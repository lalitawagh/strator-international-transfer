<?php

namespace Kanexy\InternationalTransfer\Enums;

use Kanexy\Cms\Enums\Enum;

class PaymentMethod extends Enum {
    public const MANUALLY_TRANSFER = 'manually_transfer';
    public const STRIPE = 'stripe';
    public const BANK_ACCOUNT = 'bank_account';
}
