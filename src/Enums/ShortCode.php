<?php

namespace Kanexy\InternationalTransfer\Enums;

use Kanexy\Cms\Enums\Enum;

class ShortCode extends Enum
{
    public const IB = 'Ib';
    public const BIA = 'Bia';
    public const BAP = 'Bap';
    public const AASP = 'Aasp';
    public const BBSP = 'Bbsp';
    public const I = 'I';
    public const BASP = 'Basp';
    public const BA = 'Ba';
    public const BCSP = 'Bcsp';
    public const AI = 'Ai';
    public const BBA = 'Bba';
    public const CB = 'Cb';
    public const SA = 'Sa';

    public const SHORT_CODE = 
    [
        self::IB => ['AE','CH','CZ','IL','PL','SA','BG','BH','QA','TR','PK','LI'],
        self::BIA => ['ID','JP','PH','SG','TH','ZA','NZ','OM','UG'],
        self::BAP => ['AU'],
        self::AASP => ['US'],
        self::BBSP => ['CA'],
        self::I => ['RO','CZ','AD','HU'],
        self::BASP => ['US'],
        self::BA => ['DK','KE','KW','NO','SE','SG'],
        self::BCSP => ['MX'],
        self::AI => ['IN'],
        self::BBA => ['HK'],
        self::CB => ['CN'],
        self::SA => ['GB'],
    ];

}
