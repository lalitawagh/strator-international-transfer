<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Enums\Role as EnumsRole;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\Role;
use Kanexy\Cms\Models\UserLog;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Notifications\AgentApprovedNotification;

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
        $userLog = UserLog::where('holder_id',$user->id)->get();

        if($userLog?->count() == 9 || $userLog->count() == 10)
        {
            $role =  $user->roles?->first()->pivot;
            $role->role_id = $agentRole->id;
            $role->update();
    
            $user->status = 'approved';
            $user->update();

            $membership = $user->memberships()->first();
            
            $user->notify(new AgentApprovedNotification($membership));

            return redirect()->route('dashboard.international-transfer.agent.index')->with([
                'status' => 'success',
                'message' => 'Agent approve successfully'
            ]);
        }else
        {
            return redirect()->route('dashboard.international-transfer.agent.index')->with([
                'status' => 'failed',
                'message' => 'Agent is not completed registration steps.'
            ]);
        }
       
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

    public function agentTransactions(Request $request,$id)
    {
        $user_id = $id;
        return view("international-transfer::agents.agent-transactions", compact('user_id'));
    }
}
