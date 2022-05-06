<?php

namespace Kanexy\InternationalTransfer\Enums;

use Kanexy\Cms\Enums\Enum;

class Fee extends Enum {
    public const THRESHOLD_LIMIT = 'threshold_limit';
    public const PAYMENT_TYPE = 'payment_type';
    public const SENDING_ANCHOR = 'sending_anchor';
    public const RECEIVING_ANCHOR = 'receiving_anchor';
    public const EXCHANGE_FEES = 'exchange_fee';
    public const TRANSFER_TYPE = 'transfer_type';
}
