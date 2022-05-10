<?php

namespace Kanexy\InternationalTransfer\Enums;

use Kanexy\Cms\Enums\Enum;

class PaymentStatus extends Enum {
    public const DRAFT = 'draft';
    public const ACCEPTED = 'accepted';
    public const DECLINED = 'declined';
}
