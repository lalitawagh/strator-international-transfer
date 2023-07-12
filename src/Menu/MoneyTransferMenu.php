<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;
use Kanexy\InternationalTransfer\Enums\Permission;

class MoneyTransferMenu extends Item
{
    public int $priority = 9999;

    protected string $label = 'Money Transfer';

    protected string $icon = 'octagon';

    public function getIsVisible(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(config("services.menu_layout") == 'top' && !$user->isSuperAdmin()){
            if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_CREATE)) {
                return true;
            }
        }

        return false;
    }

    public function getUrl(): string
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $workspace = $user->workspaces()->first()->id;
        
        return route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => $workspace]]);
    }
}
