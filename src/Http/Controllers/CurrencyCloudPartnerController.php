<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Models\Title;
use Kanexy\InternationalTransfer\Http\Requests\StorePartnerRequest;
use Kanexy\InternationalTransfer\Http\Requests\UpdatePartnerRequest;
use Kanexy\InternationalTransfer\Models\CcAccount;
use Kanexy\InternationalTransfer\Models\Partner;
use Kanexy\InternationalTransfer\Notifications\PartnerApproveNotification;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Laravel\Passport\ClientRepository;
use Kanexy\Cms\Setting\Models\Setting;

class CurrencyCloudPartnerController extends Controller
{
    public function index()
    {
        return view("international-transfer::partners.index");
    }

    public function approvePartners()
    {
        return view("international-transfer::partners.approved-partners");
    }

    public function create()
    {
        $titles = Title::get();
        $countries = Country::get();
        $defaultCountry = Country::find(Setting::getValue("default_country"));

        return view("international-transfer::partners.create", compact("titles", "countries", "defaultCountry"));
    }

    public function store(StorePartnerRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'inactive';
        $data['password'] = Hash::make($data['password']);

        $partner = Partner::create($data);

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
       
        return redirect()->route('dashboard.international-transfer.approve-partners')->with([
            'status' => 'success',
            'message' => 'Partner updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        Partner::find($id)->delete();

        return redirect()->route('dashboard.international-transfer.approve-partners')->with([
            'status' => 'success',
            'message' => 'Partner deleted successfully.',
        ]);
    }

    public function ccPartnerAccounts($id)
    {
        $accounts = CcAccount::where('meta->partner_holder_id',$id)->get();

        return view('international-transfer::partners.account', compact('accounts'));
    }

    public function ccPartnerTransactions($id)
    {
        $transactions = Transaction::where('initiator_id',$id)->get();

        return view('international-transfer::partners.transaction', compact('transactions'));
    }

    public function approve($id)
    {
        $partner = Partner::find($id);
        $partner->status = 'active';
        $partner->update();

        $clientRepository = app()->make(ClientRepository::class);
        $clientRepository->createPasswordGrantClient($partner->getKey(), $partner->full_name, 'https://wrappex-alpha-dev.azurewebsites.net/auth/callback', 'partners');
        $client = $partner->clients()->latest()->first();

        $partner->notify(new PartnerApproveNotification($client));

        return redirect()->route('dashboard.international-transfer.approve-partners')->with([
            'status' => 'success',
            'message' => 'Partner approved successfully.',
        ]);
    
    }
    
}
