<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Enums\Status;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration;
use Kanexy\InternationalTransfer\Http\Requests\StoreMasterAccountRequest;
use Kanexy\InternationalTransfer\Policies\MasterAccountPolicy;
use Kanexy\PartnerFoundation\Banking\Enums\ContactClassificationType;
use Kanexy\PartnerFoundation\Banking\Models\Account;
use Kanexy\PartnerFoundation\Core\Dtos\CreateBeneficiaryDto;
use Kanexy\PartnerFoundation\Core\Services\WrappexService;
use Kanexy\PartnerFoundation\Cxrm\Events\ContactCreated;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;

class MasterAccountController extends Controller
{
    private WrappexService $service;

    public function __construct(WrappexService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        $this->authorize(MasterAccountPolicy::VIEW, MasterAccountConfiguration::class);

        $account_details = Setting::getValue('money_transfer_master_account_details',[]);
        return view("international-transfer::configuration.master-account.index", compact('account_details'));
    }

    public function store(StoreMasterAccountRequest $request)
    {
        $info = $request->validated();
        $user = Auth::user();
        $info['id'] = now()->format('dmYHis');

        $account = Account::whereAccountNumber($info['account_number'])->first();

        if(is_null($account))
        {
            return redirect()->back()->withErrors(
                ['account_number' => 'Please provide '.config('app.name').' account for master account']
            );
        }else{

            $contactExist = Contact::beneficiaries()
            ->where("workspace_id", $account->holder_id)
            ->where('meta->bank_account_number', $info['account_number'])
            ->where('meta->bank_code', $info['sort_code'])
            ->first();


            if(!is_null($contactExist))
            {
                $info['beneficiary_id'] = $contactExist->id;
            }else{
                $data['type'] = 'company';
                $data['display_name'] = $info['account_holder_name'];
                $data['meta']['bank_code_type'] = 'sort-code';
                $data['meta']['bank_code'] = $info['sort_code'];
                $data['meta']['bank_account_number'] = $info['account_number'];
                $data['meta']['bank_account_name'] =  $info['account_holder_name'];
                $data['email'] = $user->email;

                $beneficiaryRefId = $this->service->createBeneficiary(
                    new CreateBeneficiaryDto($account->holder_id, $data)
                );

                $data['workspace_id'] = $account->holder_id;
                $data['ref_id']       = $beneficiaryRefId;
                $data['ref_type']     = 'wrappex';
                $data['classification'] = [ContactClassificationType::BENEFICIARY];
                $data['status'] = Status::ACTIVE;
                $data['verified_at'] = now();

                /** @var Contact $contact */
                $contact = Contact::create($data);

                event(new ContactCreated($contact));

                $info['beneficiary_id'] = $contact->id;
            }

            Setting::updateOrCreate(['key' => 'money_transfer_master_account_details'], ['value' => $info]);

            return redirect()->route('dashboard.international-transfer.master-account.index')->with([
                'status' => 'success',
                'message' => 'Account details updated successfully.',
            ]);
        }


    }

}
