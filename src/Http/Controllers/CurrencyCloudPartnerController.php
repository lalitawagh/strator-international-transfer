<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\Title;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\FeeConfiguration;
use Kanexy\InternationalTransfer\Enums\Fee;
use Kanexy\InternationalTransfer\Enums\Status;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Http\Requests\StorePartnerRequest;
use Kanexy\InternationalTransfer\Models\Partner;
use Kanexy\InternationalTransfer\Policies\FeePolicy;
use Laravel\Passport\ClientRepository;

class CurrencyCloudPartnerController extends Controller
{
    public function index()
    {
        $fee_types = Fee::toArray();
        $fees = Helper::paginate(collect(Setting::getValue('money_transfer_fees',[]))->reverse());

        return view("international-transfer::configuration.fee.index", compact('fees', 'fee_types'));
    }

    public function create()
    {
        $titles = Title::get();
        $countries = Country::get();

        return view("international-transfer::partners.create", compact("titles", "countries"));
    }

    public function store(StorePartnerRequest $request)
    {
        $data = $request->validated();
        $data['status'] = isset($data['status']) ? 'active' : 'inactive';
        $data['password'] = Hash::make($data['password']);

        $partner = Partner::create($data);

        $clientRepository = app()->make(ClientRepository::class);
        $clientRepository->createPasswordGrantClient($partner->getKey(), $partner->full_name, 'https://wrappex-alpha-dev.azurewebsites.net/auth/callback', 'partners');
      
        return redirect()->route('dashboard.international-transfer.cc-partners.index')->with([
            'status' => 'success',
            'message' => 'Partner created successfully.',
        ]);
    }

    public function edit($id)
    {
        $partner = Partner::find($id);
        $client = $partner->clients()->latest()->first();
        $titles = Title::get();
        $countries = Country::get();

        return view('international-transfer::partners.edit', compact('countries', 'titles', 'partner', 'client'));
    }

    public function update(StoreFeeRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data['amount'] = ($data['fee_type'] == 'amount') ? $data['amount'] : 0;
        $data['percentage'] = ($data['fee_type'] == 'percentage') ? $data['percentage'] : 0;

        $settings = collect(Setting::getValue('money_transfer_fees'))->map(function ($item) use ($id,$data) {
            if ($item['id'] == $id) {
                return $data;
            }

            return $item;
        });

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
