<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\TransferReasonConfiguration;
use Kanexy\InternationalTransfer\Enums\Status;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Http\Requests\StoreTransferReasonRequest;
use Kanexy\InternationalTransfer\Policies\TransferReasonPolicy;

class TransferReasonController extends Controller
{
    public function index()
    {
        $this->authorize(TransferReasonPolicy::VIEW, TransferReasonConfiguration::class);

        $money_transfer_reasons = Helper::paginate(collect(Setting::getValue('money_transfer_reasons',[]))->reverse());
        return view("international-transfer::configuration.transfer-reason.index", compact('money_transfer_reasons'));
    }

    public function create()
    {
        $this->authorize(TransferReasonPolicy::CREATE, TransferReasonConfiguration::class);
        
        $statuses = Status::toArray();
        return view("international-transfer::configuration.transfer-reason.create",compact('statuses'));
    }

    public function store(StoreTransferReasonRequest $request)
    {
        $data = $request->validated();
        $data['id'] = now()->format('dmYHis');

        $money_transfer_reason_exists = collect(Setting::getValue('money_transfer_reasons',[]))->firstWhere('reason', $data['reason']);

        if(!is_null($money_transfer_reason_exists))
        {
            return back()->withError('Transfer reason already exists');
        }

        $settings = collect(Setting::getValue('money_transfer_reasons',[]))->push($data);

        Setting::updateOrCreate(['key' => 'money_transfer_reasons'], ['value' => $settings]);

        return redirect()->route('dashboard.international-transfer.transfer-reason.index')->with([
            'status' => 'success',
            'message' => 'Transfer reason created successfully.',
        ]);
    }

    public function edit($id)
    {
        $this->authorize(TransferReasonPolicy::EDIT, TransferReasonConfiguration::class);

        $statuses = Status::toArray();
        $money_transfer_reason = collect(Setting::getValue('money_transfer_reasons',[]))->firstWhere('id', $id);

        return view("international-transfer::configuration.transfer-reason.edit", compact('money_transfer_reason', 'statuses'));
    }

    public function update(StoreTransferReasonRequest $request,$id)
    {
        $data = $request->validated();
        $data['id'] = $id;

        $money_transfer_reason_exists = collect(Setting::getValue('money_transfer_reasons',[]))->firstWhere('reason', $data['reason']);

        if(!is_null($money_transfer_reason_exists) && $money_transfer_reason_exists['id'] != $id)
        {
            return back()->withError('Transfer reason already exists');
        }


        $settings = collect(Setting::getValue('money_transfer_reasons'))->map(function ($item) use ($id,$data) {
            if ($item['id'] == $id) {
                return $data;
            }

            return $item;
        });

        Setting::updateOrCreate(['key' => 'money_transfer_reasons'], ['value' => $settings]);


        return redirect()->route("dashboard.international-transfer.transfer-reason.index")->with([
            'status' => 'success',
            'message' => 'Transfer reason updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $this->authorize(TransferReasonPolicy::DELETE, TransferReasonConfiguration::class);

        $settings = collect(Setting::getValue('money_transfer_reasons', []))->filter(function ($item) use ($id) {
            if ($item['id'] != $id) {
                return true;
            }
            return false;
        });

        Setting::updateOrCreate(['key' => 'money_transfer_reasons'], ['value' => $settings]);

        return redirect()->route("dashboard.international-transfer.transfer-reason.index")->with([
            'status' => 'success',
            'message' => 'Transfer reason deleted successfully.',
        ]);
    }
}
