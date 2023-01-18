<?php

namespace Kanexy\InternationalTransfer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;
use Kanexy\InternationalTransfer\Enums\Permission;

class RiskMgmtQuePolicy
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
        return $user->hasPermissionTo(Permission::RISK_MGMT_QUESTION_VIEW);
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo(Permission::RISK_MGMT_QUESTION_CREATE);
    }

    public function edit(User $user)
    {
        return $user->hasPermissionTo(Permission::RISK_MGMT_QUESTION_EDIT);
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo(Permission::RISK_MGMT_QUESTION_DELETE);
    }
}
