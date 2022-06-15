<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;
use Kanexy\Cms\Menu\MenuItem;

class InternationalTransferMenu extends Item
{
    public int $priority = 9999;

    protected string $label = 'International Transfer';

    protected string $icon = 'octagon';

    public function getIsVisible(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isSubscriber() && $user->is_banking_user) {
            return true;
        }
        if ($user->isSuperAdmin()) {
            return true;
        }
        return false;
    }

    public function getSubmenu(): array
    {
        /** @var $user App\Model\User */
        $user = Auth::user();

        if($user->isSubscriber() && $user->is_banking_user) {
            return [
            new MenuItem('Money Transfer', 'activity', url:route('dashboard.international-transfer.money-transfer.index',['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]])),
            ];
        }

        return [
            new MenuItem('Transactions', 'activity', url:route('dashboard.international-transfer.money-transfer.index')),
            new MenuItem('Configuration', 'activity',url:route('dashboard.international-transfer.transfer-type-fee.index')),
        ];
    }
}
