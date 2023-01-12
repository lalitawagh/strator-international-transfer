<?php

namespace Kanexy\InternationalTransfer\Menu;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Menu\Contracts\Item;
use Kanexy\Cms\Menu\MenuItem;
use Kanexy\InternationalTransfer\Enums\Permission;
use Kanexy\PartnerFoundation\Core\Enums\Permission as EnumsPermission;
use Kanexy\PartnerFoundation\Core\Helper;


class InternationalTransferMenu extends Item
{
    public int $priority = 9999;

    protected string $label = 'International Transfer';

    protected string $icon = 'octagon';

    public function getIsVisible(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasAnyPermission([Permission::MONEY_TRANSFER_VIEW, Permission::MONEY_TRANSFER_CREATE, Permission::TRANSFER_REASON_VIEW, Permission::TRANSFER_TYPE_FEE_VIEW, Permission::FEE_VIEW, Permission::MASTER_ACCOUNT_VIEW])) {
            return true;
        }

        return false;
    }

    public function getSubmenu(): array
    {
        /** @var $user App\Model\User */
        $user = Auth::user();

        $menus = [];

        if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_CREATE) && !$user->isSuperAdmin()) {
            $menus[] = new MenuItem('Money Transfer', 'activity', url: route('dashboard.international-transfer.money-transfer.index', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]));
        }

        if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_VIEW)  && $user->isSuperAdmin()) {
            $menus[] = new MenuItem('Transactions', 'activity', url: route('dashboard.international-transfer.money-transfer.index'));
        }

        if ($user->hasPermissionTo(Permission::MONEY_TRANSFER_VIEW)  && !$user->isSubscriber()) {
            $menus[] = new MenuItem('Compliance Alerts', 'activity', url: route('dashboard.international-transfer.money-transfer-review'));
        }

        if ($user->hasAnyPermission(Permission::TRANSFER_REASON_CREATE, Permission::TRANSFER_REASON_VIEW, Permission::TRANSFER_TYPE_FEE_VIEW, Permission::TRANSFER_TYPE_FEE_CREATE, Permission::FEE_VIEW, Permission::FEE_CREATE, Permission::MASTER_ACCOUNT_VIEW, Permission::MASTER_ACCOUNT_CREATE)) {
            $menus[] = new MenuItem('Configuration', 'activity', url: route('dashboard.international-transfer.transfer-type-fee.index'));
        }

        if ($user->hasAnyPermission(EnumsPermission::CONTACT_VIEW)) {
            $menus[] = new MenuItem('Beneficiaries', 'activity', url: route('dashboard.banking.beneficiaries.index', ['filter' => ['workspace_id' => Helper::activeWorkspaceId()], 'ref_type' => 'money_transfer']));
        }

        return $menus;
    }
}
