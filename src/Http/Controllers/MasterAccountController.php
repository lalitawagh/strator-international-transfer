<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration;
use Kanexy\InternationalTransfer\Http\Requests\StoreMasterAccountRequest;
use Kanexy\InternationalTransfer\Policies\MasterAccountPolicy;

class MasterAccountController extends Controller
{
    public function index()
    {
        $this->authorize(MasterAccountPolicy::VIEW, MasterAccountConfiguration::class);

        $account_details = Setting::getValue('money_transfer_master_account_details',[]);
        return view("international-transfer::configuration.master-account.index", compact('account_details'));
    }

    public function store(StoreMasterAccountRequest $request)
    {
        $data = $request->validated();
        $data['id'] = now()->format('dmYHis');

        Setting::updateOrCreate(['key' => 'money_transfer_master_account_details'], ['value' => $data]);

        return redirect()->route('dashboard.international-transfer.master-account.index')->with([
            'status' => 'success',
            'message' => 'Account details updated successfully.',
        ]);
    }

}
