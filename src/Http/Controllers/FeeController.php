<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\FeeConfiguration;
use Kanexy\InternationalTransfer\Enums\Fee;
use Kanexy\InternationalTransfer\Enums\Status;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Http\Requests\StoreFeeRequest;
use Kanexy\InternationalTransfer\Policies\FeePolicy;

class FeeController extends Controller
{
    public function index()
    {
        $this->authorize(FeePolicy::VIEW, FeeConfiguration::class);

        $fee_types = Fee::toArray();
        $fees = Helper::paginate(collect(Setting::getValue('money_transfer_fees',[])));

        return view("international-transfer::configuration.fee.index", compact('fees', 'fee_types'));
    }

    public function create()
    {
        $this->authorize(FeePolicy::CREATE, FeeConfiguration::class);

        $fee_types = Fee::toArray();
        $statuses = Status::toArray();

        return view("international-transfer::configuration.fee.create",compact('statuses', 'fee_types'));
    }

    public function store(StoreFeeRequest $request)
    {
        $data = $request->validated();
        $data['id'] = now()->format('dmYHis');

        $settings = collect(Setting::getValue('money_transfer_fees',[]))->push($data);

        Setting::updateOrCreate(['key' => 'money_transfer_fees'], ['value' => $settings]);

        return redirect()->route('dashboard.international-transfer.fee.index')->with([
            'status' => 'success',
            'message' => 'Fee created successfully.',
        ]);
    }

    public function edit($id)
    {
        $this->authorize(FeePolicy::EDIT, FeeConfiguration::class);

        $statuses = Status::toArray();
        $fee = collect(Setting::getValue('money_transfer_fees',[]))->firstWhere('id', $id);
        $fee_types = Fee::toArray();

        return view("international-transfer::configuration.fee.edit", compact('fee', 'statuses', 'fee_types'));
    }

    public function update(StoreFeeRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;

        $settings = collect(Setting::getValue('money_transfer_fees'))->filter(function ($item) use ($id) {
            if ($item['id'] != $id) {
                return true;
            }

           return false;
        });


        $settings->push($data);

        Setting::updateOrCreate(['key' => 'money_transfer_fees'], ['value' => $settings]);


        return redirect()->route("dashboard.international-transfer.fee.index")->with([
            'status' => 'success',
            'message' => 'Fee updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $this->authorize(FeePolicy::DELETE, FeeConfiguration::class);

        $settings = collect(Setting::getValue('money_transfer_fees', []))->filter(function ($item) use ($id) {
            if ($item['id'] != $id) {
                return true;
            }
            return false;
        });

        Setting::updateOrCreate(['key' => 'money_transfer_fees'], ['value' => $settings]);

        return redirect()->route("dashboard.international-transfer.fee.index")->with([
            'status' => 'success',
            'message' => 'Fee deleted successfully.',
        ]);
    }
}
