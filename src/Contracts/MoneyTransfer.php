<?php

namespace Kanexy\InternationalTransfer\Contracts;

use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Traits\InteractsWithUrn;

class MoneyTransfer extends Transaction
{
    use InteractsWithUrn;
}
