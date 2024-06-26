<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;
use Kanexy\Cms\Menu\MenuItem;
use Kanexy\InternationalTransfer\Enums\Permission;
use Kanexy\PartnerFoundation\Core\Enums\Permission as EnumsPermission;

class InternationalTransferMenu extends Item
{
    public int $priority = 9999;

    protected string $label = 'International Transfer';

    protected string $icon = 'octagon';

    public function getIsVisible(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if(config("services.registration_changed") == 'true' && !$user->isSubscriber())
        {
            if ($user->hasAnyPermission([Permission::MONEY_TRANSFER_VIEW, Permission::MONEY_TRANSFER_CREATE, Permission::TRANSFER_REASON_VIEW, Permission::TRANSFER_TYPE_FEE_VIEW, Permission::FEE_VIEW, Permission::MASTER_ACCOUNT_VIEW])) {
                return true;
            }
        }
        elseif(config('services.menu_layout') != 'top')
        {
            if ($user->hasAnyPermission([Permission::MONEY_TRANSFER_VIEW, Permission::MONEY_TRANSFER_CREATE, Permission::TRANSFER_REASON_VIEW, Permission::TRANSFER_TYPE_FEE_VIEW, Permission::FEE_VIEW, Permission::MASTER_ACCOUNT_VIEW])) {
                return true;
            }
        }

        return false;
    }

    public function getSubmenu(): array
    {
        /** @var $user App\Model\User */
        $user = Auth::user();

        $menus = [];
        if(config("services.registration_changed") == 'true' && !$user->isSubscriber())
        {
            if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_CREATE) && !$user->isSuperAdmin()) {
                $menus[] = new MenuItem('Money Transfer', 'activity', url: route('dashboard.international-transfer.money-transfer.index', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]));
            }

            if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_VIEW)  && !$user->isSubscriber()) {
                $menus[] = new MenuItem('Transactions', 'activity', url: route('dashboard.international-transfer.money-transfer.index'));
            }

            if (!$user->isSubscriber()) {
                $menus[] = new MenuItem('Conversion', 'activity', url: route('dashboard.international-transfer.conversion-list'));
            }

            if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_VIEW)  && !$user->isSubscriber()) {
                $menus[] = new MenuItem('Compliance Alerts', 'activity', url: route('dashboard.international-transfer.money-transfer-review'));
            }

            if ($user->hasAnyPermission(EnumsPermission::CONTACT_VIEW)) {
                $menus[] = new MenuItem('Beneficiaries', 'activity', url: route('dashboard.international-transfer.beneficiaries.index', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]));
            }

            if ($user->hasAnyPermission(Permission::TRANSFER_REASON_CREATE, Permission::TRANSFER_REASON_VIEW, Permission::TRANSFER_TYPE_FEE_VIEW, Permission::TRANSFER_TYPE_FEE_CREATE, Permission::FEE_VIEW, Permission::FEE_CREATE, Permission::MASTER_ACCOUNT_VIEW, Permission::MASTER_ACCOUNT_CREATE)) {
                $menus[] = new MenuItem('Configuration', 'activity', url: route('dashboard.international-transfer.transfer-type-fee.index'));
            }
        }
        else
        {
            if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_CREATE) && !$user->isSuperAdmin()) {
                $menus[] = new MenuItem('Money Transfer', 'activity', url: route('dashboard.international-transfer.money-transfer.index', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]));
            }

            if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_VIEW)  && !$user->isSubscriber()) {
                $menus[] = new MenuItem('Transactions', 'activity', url: route('dashboard.international-transfer.money-transfer.index'));
            }

            if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_VIEW)  && !$user->isSubscriber()) {
                $menus[] = new MenuItem('Compliance Alerts', 'activity', url: route('dashboard.international-transfer.money-transfer-review'));
            }

            if ($user->hasAnyPermission(EnumsPermission::CONTACT_VIEW)) {
                $menus[] = new MenuItem('Beneficiaries', 'activity', url: route('dashboard.international-transfer.beneficiaries.index', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]));
            }

            if ($user->hasAnyPermission(Permission::TRANSFER_REASON_CREATE, Permission::TRANSFER_REASON_VIEW, Permission::TRANSFER_TYPE_FEE_VIEW, Permission::TRANSFER_TYPE_FEE_CREATE, Permission::FEE_VIEW, Permission::FEE_CREATE, Permission::MASTER_ACCOUNT_VIEW, Permission::MASTER_ACCOUNT_CREATE)) {
                $menus[] = new MenuItem('Configuration', 'activity', url: route('dashboard.international-transfer.transfer-type-fee.index'));
            }
        }

        return $menus;
    }
}
