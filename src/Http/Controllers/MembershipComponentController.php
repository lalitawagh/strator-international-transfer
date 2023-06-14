<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Kanexy\PartnerFoundation\Workspace\Models\WorkspaceMeta;
class MembershipComponentController extends Controller
{
    public function showExchangeRateInfo($workspaceId)
    {
        $workspace = Workspace::findOrFail($workspaceId);
        $membership = $workspace->memberships()->first();
        $user = $workspace->users()->first();
        $workspaceMeta = WorkspaceMeta::where(['key' => 'exchangerate_info','workspace_id' => app('activeWorkspaceId')])->first();

        return view("international-transfer::membership.exchangerate-information",compact('workspace','membership','user','workspaceMeta'));
    }

    public function updateExchangeRateInformation(Request $request)
    {
        $data = $request->validate([
            'rate_type' => 'nullable',
            'customized_rate' => 'nullable|numeric|min:1',
            'percentage_rate' => 'nullable',
            'percentage' => 'nullable|numeric'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        WorkspaceMeta::updateOrCreate(['key' => 'exchangerate_info', 'workspace_id' => app('activeWorkspaceId')], ['key' => 'exchangerate_info', 'workspace_id' => app('activeWorkspaceId'), 'value' => $data]);

        return redirect()->back()->with(['message' => ' Exchange rate updated successfully.', 'status' => 'success']);
    }

}
