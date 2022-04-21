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
        return true;
    }

    public function getSubmenu(): array
    {
        /** @var $user App\Model\User */
        $user = Auth::user();

        if($user->isSubscriber()) {
            return [
            new MenuItem('Money transfer', 'activity'),
            ];
        }

        return [
            new MenuItem('Configuration', 'activity',url:route('dashboard.international-transfer.transfer-type-fee.index')),
        ];
    }
}
