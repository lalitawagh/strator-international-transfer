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

    public const SHORT_CODE = [
        self::IB => ['AE','CH','IL','PL','SA','BG','BH','QA','TR','PK','LI'],
        self::BIA => ['SG','TH','ZA','NZ','OM','UG','ID','JP','PH',],
        self::BAP => ['AU','CC','CX','HM','NR','TV','NF','KI'],
        self::AASP => ['AS','US','BQ','EC','FM','TC','PW','IO','GU','MH','MP','PR','TL','UM','VG','VI','ZW'],
        self::BBSP => ['CA'],
        self::I => ['RO','CZ','AD','HU','AT','AX','BE','BL','CY','DE','EE','ES','FI','FR','GF','GP','GR','IE','IT','LT','LU'],
        self::BASP => ['BQ'],
        self::BA => ['DK','KE','KW','NO','SE','SG','BV','SJ'],
        self::BCSP => ['MX'],
        self::AI => ['IN'],
        self::BBA => ['HK'],
        self::CB => ['CN'],
        self::SA => ['GB','GG','GS','IM','JE','UK'],
    ];

}
