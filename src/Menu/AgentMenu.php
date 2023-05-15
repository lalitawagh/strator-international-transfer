<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;
use Kanexy\Cms\Menu\MenuItem;

class AgentMenu extends Item
{
    public int $priority = 9999;

    protected string $label = 'Agents';

    protected string $icon = 'user-check';

    public function getIsVisible(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
       
        if (!$user->isSubscriber()) {
            return true;
        }

        return false;
    }

    public function getSubmenu(): array
    {
        /** @var $user App\Model\User */
        $user = Auth::user();

        $menus = [];

        $menus[] = new MenuItem('Agent Request', 'activity', url: route('dashboard.international-transfer.agent-request'));
        $menus[] = new MenuItem('Approved Agent', 'activity', url: route('dashboard.international-transfer.agent.index'));

        return $menus;
    }
}
