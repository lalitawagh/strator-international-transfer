<?php

namespace Kanexy\InternationalTransfer\Membership;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Kanexy\Cms\Components\Contracts\Component;
use Kanexy\InternationalTransfer\Models\CcAccount;
use Kanexy\InternationalTransfer\Models\CcCurrencyConversion;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;

class MembershipSubAccountComponent extends Component
{
    use AuthorizesRequests;

    public function render()
    {
        $workspace = Workspace::find(request()->route('workspace'));
        $membership = $workspace?->memberships()->first();
        $user = $workspace?->users()->first();
        $account = CcAccount::forHolder($workspace)->first();
        $balances = CcCurrencyConversion::where(['holder_id' => $workspace->id, 'currency' => 'GBP'])->first();
        //dd($balances);

        return view("international-transfer::membership.membership-subaccount-component", compact('account','balances'));
    }
}
