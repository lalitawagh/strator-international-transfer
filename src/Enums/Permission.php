<?php

namespace Kanexy\InternationalTransfer\Enums;

class Permission
{
    public const TRANSFER_TYPE_FEE_VIEW   = 'international-transfer::transfer_type_fee.view';
    public const TRANSFER_TYPE_FEE_CREATE = 'international-transfer::transfer_type_fee.create';
    public const TRANSFER_TYPE_FEE_EDIT   = 'international-transfer::transfer_type_fee.edit';
    public const TRANSFER_TYPE_FEE_DELETE = 'international-transfer::transfer_type_fee.delete';

    public const FEE_VIEW   = 'international-transfer::fee.view';
    public const FEE_CREATE = 'international-transfer::fee.create';
    public const FEE_EDIT   = 'international-transfer::fee.edit';
    public const FEE_DELETE = 'international-transfer::fee.delete';
}
