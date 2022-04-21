<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\CollectionAccountConfiguration;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Http\Requests\StoreCollectionAccountRequest;
use Kanexy\InternationalTransfer\Policies\CollectionAccountPolicy;

class CollectionAccountController extends Controller
{
    public function index()
    {
        $this->authorize(CollectionAccountPolicy::VIEW, CollectionAccountConfiguration::class);

        $account_details = Setting::getValue('money_transfer_collection_account_details',[]);
        return view("international-transfer::configuration.collection-account.index", compact('account_details'));
    }

    public function store(StoreCollectionAccountRequest $request)
    {
        $data = $request->validated();
        $data['id'] = now()->format('dmYHis');

        Setting::updateOrCreate(['key' => 'money_transfer_collection_account_details'], ['value' => $data]);

        return redirect()->route('dashboard.international-transfer.collection-account.index')->with([
            'status' => 'success',
            'message' => 'Account details updated successfully.',
        ]);
    }

}
