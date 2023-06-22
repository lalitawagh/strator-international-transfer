<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\Title;
use Kanexy\InternationalTransfer\Http\Requests\StorePartnerRequest;
use Kanexy\InternationalTransfer\Http\Requests\UpdatePartnerRequest;
use Kanexy\InternationalTransfer\Models\Partner;
use Laravel\Passport\ClientRepository;

class CurrencyCloudPartnerController extends Controller
{
    public function index()
    {
        return view("international-transfer::partners.index");
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

    public function edit($partner)
    {
        $partner = Partner::find($partner);
        $client = $partner->clients()->latest()->first();
        $titles = Title::get();
        $countries = Country::get();

        return view('international-transfer::partners.edit', compact('countries', 'titles', 'partner', 'client'));
    }

    public function update(UpdatePartnerRequest $request, $id)
    {
        $data = $request->validated();

        $data['status'] = isset($data['status']) ? 'active' : 'inactive';

        $partner = Partner::find($id);
        $partner->fill($data)->save();
       
        return redirect()->route('dashboard.international-transfer.cc-partners.index')->with([
            'status' => 'success',
            'message' => 'Partner updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        Partner::find($id)->delete();

        return redirect()->route('dashboard.international-transfer.cc-partners.index')->with([
            'status' => 'success',
            'message' => 'Partner deleted successfully.',
        ]);
    }
}
