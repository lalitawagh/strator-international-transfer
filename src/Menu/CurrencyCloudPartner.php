<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;
use Kanexy\Cms\Menu\MenuItem;

class CurrencyCloudPartner extends Item
{
    public int $priority = 9999;

    protected string $label = 'Fx Hub';

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
        if($user->isSuperAdmin())
        {
            $menus[] = new MenuItem('CC Partners', 'activity', childmenu:[
                new MenuItem('CC Partners Request', 'zap', url: route('dashboard.international-transfer.cc-partners.index')),
                // Admin dashboard design
                new MenuItem('Approved CC Partners', 'zap', url: route('dashboard.international-transfer.approve-partners')),
                // Admin dashboard design
            ]);
        }

        if (!$user->isSubscriber() && !$user->hasRole('agent')) {
            $menus[] = new MenuItem('Agents', 'activity', childmenu:[
                new MenuItem('Agent Request', 'zap', url: route('dashboard.international-transfer.agent-request')),
                // Admin dashboard design
                new MenuItem('Approved Agent', 'zap', url: route('dashboard.international-transfer.agent.index')),
                // Admin dashboard design
            ]);
        }
        
        if ($user->hasRole('agent')) {
            $menus[] = new MenuItem('Agent Users', 'activity', url: route('dashboard.international-transfer.agent-users', $user->getKey()));
        }
        

        return $menus;
    }

}
