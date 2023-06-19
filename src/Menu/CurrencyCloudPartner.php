<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;
use Kanexy\Cms\Menu\MenuItem;

class CurrencyCloudPartner extends Item
{
    public int $priority = 9999;

    protected string $label = 'CC Partners';

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

    public function getUrl(): string
    {
        return route('dashboard.international-transfer.cc-partners.index');
    }
}
