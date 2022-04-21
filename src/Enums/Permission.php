<?php

namespace Kanexy\InternationalTransfer\Enums;

class Permission
{
    public const TRANSFER_TYPE_FEE_VIEW   = 'international-transfer::transfer_type_fee.view';
    public const TRANSFER_TYPE_FEE_CREATE = 'international-transfer::transfer_type_fee.create';
    public const TRANSFER_TYPE_FEE_EDIT   = 'international-transfer::transfer_type_fee.edit';
    public const TRANSFER_TYPE_FEE_DELETE = 'international-transfer::transfer_type_fee.delete';


    public const TRANSFER_REASON_VIEW   = 'international-transfer::transfer_reason.view';
    public const TRANSFER_REASON_CREATE = 'international-transfer::transfer_reason.create';
    public const TRANSFER_REASON_EDIT   = 'international-transfer::transfer_reason.edit';
    public const TRANSFER_REASON_DELETE = 'international-transfer::transfer_reason.delete';
}
