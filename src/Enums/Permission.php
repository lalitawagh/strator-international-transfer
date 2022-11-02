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

    public const MASTER_ACCOUNT_VIEW   = 'international-transfer::master_account.view';
    public const MASTER_ACCOUNT_CREATE = 'international-transfer::master_account.create';
    public const MASTER_ACCOUNT_EDIT   = 'international-transfer::master_account.edit';
    public const MASTER_ACCOUNT_DELETE = 'international-transfer::master_account.delete';

    public const FEE_VIEW   = 'international-transfer::fee.view';
    public const FEE_CREATE = 'international-transfer::fee.create';
    public const FEE_EDIT   = 'international-transfer::fee.edit';
    public const FEE_DELETE = 'international-transfer::fee.delete';

    public const MONEY_TRANSFER_VIEW   = 'international-transfer::money_transfer.view';
    public const MONEY_TRANSFER_CREATE = 'international-transfer::money_transfer.create';

}
