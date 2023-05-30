<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Enums\Role as EnumsRole;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\Role;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\PartnerFoundation\Workspace\Models\WorkspaceMeta;

class AgentController extends Controller
{
    public function index()
    {
        return view("international-transfer::agents.agent-approve");
    }

    public function agentRequest()
    {
        return view("international-transfer::agents.agent-request");
    }

    public function agentDetail($id)
    {
        $user = User::find($id);
        $countries = Country::orderBy("name")->pluck("name", "id");
        $defaultCountry = Country::find(Setting::getValue("default_country"));
        $roles = Role::with(['permissions'])->whereNotIn('name', [
            EnumsRole::SUPER_ADMIN,
            EnumsRole::WORKSPACE,
        ])->latest()->get();
        $countryWithFlags = Country::orderBy("name")->get();

        return view("international-transfer::agents.agent-detail", compact('user', 'countries', 'roles', 'defaultCountry', 'countryWithFlags'));
    }

    public function show($id)
    {
        $agentRole = Role::whereName(EnumsRole::AGENT)->first();
        $user = User::find($id);
        $workspace = $user->workspaces()->first();
        $role =  $user->roles?->first()->pivot;
        $role->role_id = $agentRole->id;
        $role->update();

        $user->status = 'approved';
        $user->update();

        return redirect()->route('dashboard.international-transfer.agent.index')->with([
            'status' => 'success',
            'message' => 'Agent approve successfully'
        ]);
    }

    public function agentUsers(Request $request,$id)
    {
        if(!auth()->user()->isSuperAdmin())
        {
            if (! Gate::allows('agent-users', $id)) {
                abort(403);
            }
        }

        $user_id = $id;
        return view("international-transfer::agents.agent-users", compact('user_id'));
    }
}
