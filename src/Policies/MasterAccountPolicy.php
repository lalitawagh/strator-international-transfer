<?php

namespace Kanexy\InternationalTransfer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;
use Kanexy\InternationalTransfer\Enums\Permission;

class MasterAccountPolicy
{
    use HandlesAuthorization;

    public const VIEW = 'view';

    public const CREATE = 'create';

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
        return $user->hasPermissionTo(Permission::MASTER_ACCOUNT_VIEW);
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo(Permission::MASTER_ACCOUNT_CREATE);
    }
}
