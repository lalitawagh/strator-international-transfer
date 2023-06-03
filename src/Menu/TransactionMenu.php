<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;
use Kanexy\InternationalTransfer\Enums\Permission;

class TransactionMenu extends Item
{
    public int $priority = 10000;

    protected string $label = 'Transactions';

    protected string $icon = 'list';

    public function getIsVisible(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(config("services.menu_layout") == 'top' && $user->isSubscriber()){
            if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_VIEW)) {
                return true;
            }
        }

        return false;
    }

    public function getUrl(): string
    {
        return route('dashboard.international-transfer.money-transfer.index', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]);
    }
}
