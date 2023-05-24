<?php

namespace Kanexy\InternationalTransfer\Enums;

use Kanexy\Cms\Enums\Enum;

class ShortCode extends Enum
{
    public const IB = 'Ib';
    public const BIA = 'Bia';
    public const BAP = 'Bap';
    public const AASP = 'Aasp';
    public const BBSP = 'BBSP';
    public const I = 'I';
    public const BASP = 'Basp';
    public const BA = 'Ba';
    public const BCSP = 'BCSP';
    public const AI = 'Ai';
    public const BBA = 'BBA';
    public const CB = 'Cb';
    public const SA = 'Sa';

    public const SHORT_CODE = [
        self::IB => 'Ib',
        self::BIA => 'Bia',
        self::BAP => 'Bap',
        self::AASP => 'Aasp',
        self::BBSP => 'Bbsp',
        self::I => 'I',
        self::BASP => 'Basp',
        self::BA => 'Ba',
        self::AI => 'Ai',
        self::BCSP => 'Bcsp',
        self::BBA => 'Bba',
        self::CB => 'Cb',
        self::SA => 'Sa'
    ];

}
