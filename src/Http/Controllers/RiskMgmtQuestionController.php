<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\RiskMgmtQueConfiguration;
use Kanexy\InternationalTransfer\Enums\Status;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Http\Requests\StoreRiskMgmtQueRequest;
use Kanexy\InternationalTransfer\Policies\RiskMgmtQuePolicy;

class RiskMgmtQuestionController extends Controller
{
    public function index()
    {
        $this->authorize(RiskMgmtQuePolicy::VIEW, RiskMgmtQueConfiguration::class);

        $risk_mgmnt_questions = Helper::paginate(collect(Setting::getValue('risk_management_questions',[]))->reverse());
        return view("international-transfer::configuration.risk-management-questions.index",compact('risk_mgmnt_questions'));
    }

    public function create()
    {
        $this->authorize(RiskMgmtQuePolicy::CREATE, RiskMgmtQueConfiguration::class);

        $statuses = Status::toArray();
        return view("international-transfer::configuration.risk-management-questions.create",compact('statuses'));
    }

    public function store(StoreRiskMgmtQueRequest $request)
    {
        $data = $request->validated();
        $data['id'] = rand(11111, 99999);

        $settings = collect(Setting::getValue('risk_management_questions',[]))->push($data);

        Setting::updateOrCreate(['key' => 'risk_management_questions'], ['value' => $settings]);

        return redirect()->route('dashboard.international-transfer.risk-management-questions.index')->with([
            'status' => 'success',
            'message' => 'Question created successfully.',
        ]);
    }

    public function edit($id)
    {
        $this->authorize(RiskMgmtQuePolicy::EDIT, RiskMgmtQueConfiguration::class);

        $statuses = Status::toArray();
        $risk_mgmnt_question = collect(Setting::getValue('risk_management_questions',[]))->firstWhere('id', $id);

        return view("international-transfer::configuration.risk-management-questions.edit", compact('risk_mgmnt_question', 'statuses'));
    }

    public function update(StoreRiskMgmtQueRequest $request,$id)
    {
        $data = $request->validated();
        $data['id'] = $id;

        $settings = collect(Setting::getValue('risk_management_questions'))->map(function ($item) use ($id,$data) {
            if ($item['id'] == $id) {
                return $data;
            }

            return $item;
        });

        Setting::updateOrCreate(['key' => 'risk_management_questions'], ['value' => $settings]);


        return redirect()->route("dashboard.international-transfer.risk-management-questions.index")->with([
            'status' => 'success',
            'message' => 'Question updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $this->authorize(RiskMgmtQuePolicy::DELETE, RiskMgmtQueConfiguration::class);

        $settings = collect(Setting::getValue('risk_management_questions', []))->filter(function ($item) use ($id) {
            if ($item['id'] != $id) {
                return true;
            }
            return false;
        });

        Setting::updateOrCreate(['key' => 'risk_management_questions'], ['value' => $settings]);

        return redirect()->route("dashboard.international-transfer.risk-management-questions.index")->with([
            'status' => 'success',
            'message' => 'Question deleted successfully.',
        ]);
    }
}
