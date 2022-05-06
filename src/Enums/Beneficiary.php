<?php

namespace Kanexy\InternationalTransfer\Enums;

use Kanexy\Cms\Enums\Enum;

class Beneficiary extends Enum {
    public const MYSELF = 'myself';
    public const SOMEONE_ELSE = 'someone-else';
    public const BUSINESS = 'business';
}
