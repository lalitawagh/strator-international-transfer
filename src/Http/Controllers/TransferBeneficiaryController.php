<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Illuminate\Http\Request;
use Kanexy\Cms\Controllers\Controller;
use Kanexy\PartnerFoundation\Cxrm\Policies\ContactPolicy;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TransferBeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        }

        $beneficiaries = $contacts->beneficiaries()->where('ref_type', '=', 'money_transfer')->verified()->latest()->paginate();

        return view("partner-foundation::banking.beneficiaries.index", compact('beneficiaries', 'workspace'));
    }
}
