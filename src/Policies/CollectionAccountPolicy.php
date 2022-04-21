<?php

namespace Kanexy\InternationalTransfer\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Kanexy\InternationalTransfer\Enums\Permission;

class CollectionAccountPolicy
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
        return $user->hasPermissionTo(Permission::COLLECTION_ACCOUNT_VIEW);
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo(Permission::COLLECTION_ACCOUNT_CREATE);
    }
}
