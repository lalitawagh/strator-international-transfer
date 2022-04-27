<?php

namespace Kanexy\InternationalTransfer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;
use Kanexy\InternationalTransfer\Enums\Permission;

class TransferReasonPolicy
{
    use HandlesAuthorization;

    public const VIEW = 'view';

    public const CREATE = 'create';

    public const EDIT = 'edit';

    public const DELETE = 'delete';

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user)
    {
        return $user->hasPermissionTo(Permission::TRANSFER_REASON_VIEW);
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo(Permission::TRANSFER_REASON_CREATE);
    }

    public function edit(User $user)
    {
        return $user->hasPermissionTo(Permission::TRANSFER_REASON_EDIT);
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo(Permission::TRANSFER_REASON_DELETE);
    }
}
