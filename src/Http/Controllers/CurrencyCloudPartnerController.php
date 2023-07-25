<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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
use Kanexy\InternationalTransfer\Models\PartnerStorageDetail;
use Kanexy\PartnerFoundation\Core\Models\Document;
use Kanexy\PartnerFoundation\Core\Models\DocumentType;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;

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

    public function partnerUsersKyc($partnerId,$id)
    {
        $account = CcAccount::find($id);
        $partner = Partner::find($partnerId);
        $data = ['type' => 'get-partner-users-kyc'];
        
        $existPartnerStorageDetails = PartnerStorageDetail::wherePartnerId($partnerId)->first();
        // $response =  Http::post($partner->webhook_url,$data);
        if(is_null($existPartnerStorageDetails))
        {
            $response =  Http::get($partner->kyc_url.'/cc-partner-users-kyc/'.$account->ref_id)->throw()
            ->json();
            
            PartnerStorageDetail::create([
                'partner_id' => $partnerId,
                'name' => $response['storageDetail']['AZURE_STORAGE_NAME'],
                'key' => $response['storageDetail']['AZURE_STORAGE_KEY'],
                'container' => $response['storageDetail']['AZURE_STORAGE_CONTAINER'],
                'url' => $response['storageDetail']['AZURE_STORAGE_URL'],
            ]);

            foreach($response['doucments'] as $document)
            {
                Document::create([
                    'document_type_id' => $document['document_type_id'],
                    'media' => $document['media'],
                    'holder_type' => $partner->getMorphClass(),
                    'holder_id' => $partner->getKey(),
                    'type' => $document['type'],
                    'status' => $document['status'],
                ]);
            }
            Config::set('filesystems.disks.azure.name',$response['storageDetail']['AZURE_STORAGE_NAME']);
            Config::set('filesystems.disks.azure.key',$response['storageDetail']['AZURE_STORAGE_KEY']);
            Config::set('filesystems.disks.azure.container',$response['storageDetail']['AZURE_STORAGE_CONTAINER']);
            Config::set('filesystems.disks.azure.url',$response['storageDetail']['AZURE_STORAGE_URL']);

        }else
        {
            Config::set('filesystems.disks.azure.name',$existPartnerStorageDetails->name);
            Config::set('filesystems.disks.azure.key',$existPartnerStorageDetails->key);
            Config::set('filesystems.disks.azure.container',$existPartnerStorageDetails->container);
            Config::set('filesystems.disks.azure.url',$existPartnerStorageDetails->url);
        }
        
        $documents = Document::where(['holder_id' => $partner->getKey(),'holder_type' => $partner->getMorphClass()])->get();
       
        return view('international-transfer::partners.document', compact('documents')) ;           
    }

    public function ccPartnerUsersKycDetails($id)
    {
        $account = CcAccount::whereRefId($id)->first();
        $workspace = Workspace::find($account->holder_id);
        $user = $workspace->users()->first();
        $workspaceDoucment = Document::where(['holder_id' => $workspace->id, 'holder_type' => $workspace->getMorphClass()])->get();
        $userDoucment = Document::where(['holder_id' => $user->id, 'holder_type' => $user->getMorphClass()])->get();
        $finalDocument = $workspaceDoucment->merge($userDoucment);
        $storageDetail = [
            'AZURE_STORAGE_NAME' => config('filesystems.disks.azure.name'),
            'AZURE_STORAGE_KEY' => config('filesystems.disks.azure.key'),
            'AZURE_STORAGE_CONTAINER' => config('filesystems.disks.azure.container'),
            'AZURE_STORAGE_URL' =>  config('filesystems.disks.azure.url'),
        ];
        
        $detail = [
            'doucments' => $finalDocument,
            'storageDetail' => $storageDetail
        ];
        
        return $detail;
    }
    
}
