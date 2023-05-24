<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;
use Kanexy\PartnerFoundation\Core\Enums\Permission as EnumsPermission;

class BeneficiariesMenu extends Item
{
    public int $priority = 10000;

    protected string $label = 'Beneficiaries';

    protected string $icon = 'activity';

    public function getIsVisible(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(config("services.menu_layout") == 'top' && $user->isSubscriber()){
            if ($user->hasAnyPermission(EnumsPermission::CONTACT_VIEW)) {
                return true;
            }
        }

        return false;
    }

    public function getUrl(): string
    {
        return route('dashboard.international-transfer.beneficiaries.index', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]);
    }
}
