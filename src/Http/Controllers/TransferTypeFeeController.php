<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\TransferTypeFeeConfiguration;
use Kanexy\InternationalTransfer\Enums\Status;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Http\Requests\StoreTransferTypeFeeRequest;
use Kanexy\InternationalTransfer\Policies\TransferTypeFeePolicy;

class TransferTypeFeeController extends Controller
{
    public function index()
    {
        $this->authorize(TransferTypeFeePolicy::VIEW, TransferTypeFeeConfiguration::class);

        $transfer_type_fees = Helper::paginate(collect(Setting::getValue('money_transfer_type_fees',[])));
        return view("international-transfer::configuration.transfer-type.index", compact('transfer_type_fees'));
    }

    public function create()
    {
        $this->authorize(TransferTypeFeePolicy::CREATE, TransferTypeFeeConfiguration::class);

        $statuses = Status::toArray();
        return view("international-transfer::configuration.transfer-type.create",compact('statuses'));
    }

    public function store(StoreTransferTypeFeeRequest $request)
    {
        $data = $request->validated();
        $data['id'] = now()->format('dmYHis');

        $settings = collect(Setting::getValue('money_transfer_type_fees',[]))->push($data);

        Setting::updateOrCreate(['key' => 'money_transfer_type_fees'], ['value' => $settings]);

        return redirect()->route('dashboard.international-transfer.transfer-type-fee.index')->with([
            'status' => 'success',
            'message' => 'Transfer type created successfully.',
        ]);
    }

    public function edit($id)
    {
        $this->authorize(TransferTypeFeePolicy::EDIT, TransferTypeFeeConfiguration::class);

        $statuses = Status::toArray();
        $transfer_type_fee = collect(Setting::getValue('money_transfer_type_fees',[]))->firstWhere('id', $id);

        return view("international-transfer::configuration.transfer-type.edit", compact('transfer_type_fee', 'statuses'));
    }

    public function update(StoreTransferTypeFeeRequest $request,$id)
    {
        $data = $request->validated();
        $data['id'] = $id;

        $settings = collect(Setting::getValue('money_transfer_type_fees'))->filter(function ($item) use ($id) {
            if ($item['id'] != $id) {
                return true;
            }

           return false;
        });


        $settings->push($data);

        Setting::updateOrCreate(['key' => 'money_transfer_type_fees'], ['value' => $settings]);


        return redirect()->route("dashboard.international-transfer.transfer-type-fee.index")->with([
            'status' => 'success',
            'message' => 'Transfer type fee updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $this->authorize(TransferTypeFeePolicy::DELETE, TransferTypeFeeConfiguration::class);

        $settings = collect(Setting::getValue('money_transfer_type_fees', []))->filter(function ($item) use ($id) {
            if ($item['id'] != $id) {
                return true;
            }
            return false;
        });

        Setting::updateOrCreate(['key' => 'money_transfer_type_fees'], ['value' => $settings]);

        return redirect()->route("dashboard.international-transfer.transfer-type-fee.index")->with([
            'status' => 'success',
            'message' => 'Transfer type fee deleted successfully.',
        ]);
    }
}
