<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;

class AgentUser extends Item
{
    public int $priority = 9999;

    protected string $label = 'Agent Users';

    protected string $icon = 'user-check';

    public function getIsVisible(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
       
        if ($user->hasRole('agent')) {
            return true;
        }

        return false;
    }

    public function getUrl(): string
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return route('dashboard.international-transfer.agent-users', $user->getKey());
    }
}
