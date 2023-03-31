<?php

namespace Kanexy\InternationalTransfer\Enums;

use Kanexy\Cms\Enums\Enum;

class FlagStatus extends Enum
{
    public const GREEN = 'Green';
    public const YELLOW = 'Yellow';
    public const RED = 'Red';
    public const BLUE = 'Blue';
    public const PURPLE = 'Purple';
    public const CYAN = 'Cyan';
    public const GOLD = 'Gold';
    public const BROWN = 'Brown';
    public const GRAY = 'Gray';

    public const FLAG_STATUS = [
        self::GREEN => 'Green',
        self::YELLOW => 'Yellow',
        self::RED => 'Red',
        self::BLUE => 'Blue',
        self::PURPLE => 'Purple',
        self::CYAN => 'Cyan',
        self::GOLD => 'Gold',
        self::BROWN => 'Brown',
        self::GRAY => 'Gray',
    ];
}
