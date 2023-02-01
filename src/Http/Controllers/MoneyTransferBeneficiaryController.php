<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Http\Request;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Helper;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Http\Requests\UpdateBeneficiaryRequest;
use Kanexy\PartnerFoundation\Cxrm\Events\ContactDeleted;
use Kanexy\PartnerFoundation\Cxrm\Events\ContactDeleting;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Kanexy\PartnerFoundation\Cxrm\Policies\ContactPolicy;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MoneyTransferBeneficiaryController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize(ContactPolicy::INDEX, Contact::class);

        $contacts = QueryBuilder::for(Contact::class)
            ->allowedFilters([
                AllowedFilter::exact('workspace_id'),
            ]);

        $workspace = null;

        if ($request->has('filter.workspace_id')) {
            $workspace = Workspace::findOrFail($request->input('filter.workspace_id'));
            $beneficiaries = $contacts->beneficiaries()->where('workspace_id', $workspace->id)->where('ref_type', 'money_transfer')->verified()->latest()->paginate();
        } else {
            $beneficiaries = $contacts->beneficiaries()->where('ref_type', 'money_transfer')->verified()->latest()->paginate();
        }

        return view("international-transfer::beneficiaries.index", compact('beneficiaries', 'workspace'));
    }

    public function edit(Contact $beneficiary)
    {
        $this->authorize(ContactPolicy::EDIT, $beneficiary);

        $countries = Country::get();
        $defaultCountry = Setting::getValue('default_country');
        return view("international-transfer::beneficiaries.edit", compact('beneficiary', 'countries', 'defaultCountry'));
    }

    public function update(UpdateBeneficiaryRequest $request, Contact $beneficiary)
    {
        $data = $request->validated();

        if ($data['type'] == 'company') {
            $data['display_name'] = Helper::removeExtraSpace($data['company_name']);
        } else {
            $data['display_name'] = Helper::removeExtraSpace(implode(' ', [$data['first_name'], $data['middle_name'], $data['last_name']]));
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('Images', 'azure');
        }

        $beneficiary->update($data);

        return redirect()->route("dashboard.international-transfer.beneficiaries.index", ['filter' => ['workspace_id' => $beneficiary->workspace_id]])->with([
            'status' => 'success',
            'message' => 'The beneficiary updated successfully.',
        ]);
    }

    public function destroy(Contact $beneficiary)
    {
        $this->authorize(ContactPolicy::DELETE, $beneficiary);

        event(new ContactDeleting($beneficiary));

        $beneficiary->delete();

        event(new ContactDeleted($beneficiary));

        return redirect()->route("dashboard.international-transfer.beneficiaries.index", ['filter' => ['workspace_id' => $beneficiary->workspace_id]])->with([
            'status' => 'success',
            'message' => 'The beneficiary deleted successfully.',
        ]);
    }
}
