<?php

namespace Kanexy\InternationalTransfer\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Kanexy\InternationalTransfer\Enums\Permission;

class FeePolicy
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
        return $user->hasPermissionTo(Permission::TRANSFER_TYPE_FEE_VIEW);
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo(Permission::TRANSFER_TYPE_FEE_CREATE);
    }

    public function edit(User $user)
    {
        return $user->hasPermissionTo(Permission::TRANSFER_TYPE_FEE_EDIT);
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo(Permission::TRANSFER_TYPE_FEE_DELETE);
    }
}
