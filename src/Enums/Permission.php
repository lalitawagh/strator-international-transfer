<?php

namespace Kanexy\InternationalTransfer\Enums;

class Permission
{
    public const TRANSFER_TYPE_FEE_VIEW   = 'international-transfer::transfer_type_fee.view';
    public const TRANSFER_TYPE_FEE_CREATE = 'international-transfer::transfer_type_fee.create';
    public const TRANSFER_TYPE_FEE_EDIT   = 'international-transfer::transfer_type_fee.edit';
    public const TRANSFER_TYPE_FEE_DELETE = 'international-transfer::transfer_type_fee.delete';


    public const COLLECTION_ACCOUNT_VIEW   = 'international-transfer::collection_account.view';
    public const COLLECTION_ACCOUNT_CREATE = 'international-transfer::collection_create.create';
}
