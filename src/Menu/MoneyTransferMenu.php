<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;

class MoneyTransferMenu extends Item
{
    public int $priority = 9999;

    protected string $label = 'Money Transfer';

    protected string $icon = 'list';

    public function getIsVisible(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(config("services.menu_layout") == 'top' && $user->isSubscriber()){
            return true;
        }

        // if ($user->hasPermissionTo(Permission::CARD_VIEW) && config('services.disable_banking') == false) {
        //     return true;
        // }

        return false;
    }

    public function getUrl(): string
    {
        return route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]);
    }
}
