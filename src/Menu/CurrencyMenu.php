<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;
use Kanexy\InternationalTransfer\Enums\Permission;

class CurrencyMenu extends Item
{
    public int $priority = 9999;

    protected string $label = 'Currency';

    protected string $icon = 'octagon';

    public function getIsVisible(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(config("services.menu_layout") == 'top' && !$user->isSuperAdmin()){
                return true;
        }

        return false;
    }

    // public function getUrl(): string
    // {
    //     return route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]);
    // }
}
