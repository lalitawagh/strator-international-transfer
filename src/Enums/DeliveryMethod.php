<?php

namespace Kanexy\InternationalTransfer\Enums;

use Kanexy\Cms\Enums\Enum;

class DeliveryMethod extends Enum
{
    public const BANK = 'Bank';
    public const MANUAL = 'Manual';

    public const DELIVERY_METHOD = [
        self::BANK => 'Bank',
        self::MANUAL => 'Manual'
    ];
}