<?php

namespace Kanexy\InternationalTransfer\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;
use Kanexy\InternationalTransfer\Enums\Permission;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;

class MoneyTransferPolicy
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
        if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_VIEW)) {
            return true;
        }
        $workspaceId = request()->input('filter.workspace_id');

        return $user->workspaces()->where('workspace_id', $workspaceId)->exists();
    }

    public function create(User $user)
    {

        $workspaceId = request()->input('workspace_id', request()->input('filter.workspace_id'));

        if (empty($workspaceId)) {
            return false;
        }

        $workspace = Workspace::findOrFail($workspaceId);

        if ($workspace->users()->where('user_id', $user->id)->exists()) {
            return true;
        }

        return $user->hasPermissionTo(Permission::MONEY_TRANSFER_CREATE);
    }
}
