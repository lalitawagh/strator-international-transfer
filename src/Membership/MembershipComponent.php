<?php

namespace Kanexy\InternationalTransfer\Membership;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Kanexy\Banking\Models\Account;
use Kanexy\Cms\Components\Contracts\Component;
use Kanexy\PartnerFoundation\Membership\Policies\MembershipPolicy;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;

class MembershipComponent extends Component
{
    use AuthorizesRequests;

    public function render()
    {
        $workspace = Workspace::findOrFail(request()->route('workspace'));
        $membership = $workspace->memberships()->first();
        $user = $workspace->users()->first();

        return view("international-transfer::membership.membership-component", compact('workspace', 'membership', 'user'));
    }
}
