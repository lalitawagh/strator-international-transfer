<?php

namespace Kanexy\InternationalTransfer\Contracts;

use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Traits\InteractsWithUrn;

class MoneyTransfer extends Transaction
{
    use InteractsWithUrn;
}
