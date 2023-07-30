<?php

namespace Kanexy\InternationalTransfer\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Kanexy\InternationalTransfer\Models\Partner;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class CcPartners extends Transaction
{
    public static function setBuilder($workspace_id,$type): Builder
    {
        return Partner::query()->where('status','active')->latest();
    }

    public static function setBulkActions()
    {
        return false;
    }

    public static function setPagination()
    {
        return true;
    }

    public static function setArchived()
    {
        return false;
    }

    public static function setUnArchived()
    {
        return false;
    }

    public static function columns()
    {
        
        return [
            Column::make("Id", "id")->hideIf(true),

            Column::make("First Name", "first_name")
                ->searchable()
                ->secondaryHeaderFilter('first_name'),

            Column::make("Last Name", "last_name")
                ->searchable()
                ->secondaryHeaderFilter('last_name'),

            Column::make("Email", "email")
                ->searchable()
                ->secondaryHeaderFilter('email'),

            Column::make("Phone", "phone")
                ->searchable()
                ->secondaryHeaderFilter('phone'),

            Column::make('Actions','id')->format(function($value, $model, $row) {
                $actions[] = ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit-2" data-lucide="edit-2" class="lucide lucide-edit-2 w-4 h-4 mr-2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>','isOverlay' => '0','method' => 'GET','route' => route('dashboard.international-transfer.cc-partners.edit', $value),'action' => 'Edit'];
                $actions[] = ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash" data-lucide="trash" class="lucide lucide-trash w-4 h-4 mr-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path></svg>','isOverlay' => 'true','method' => 'GET','action' => "Delete",
                'route' => "Livewire.emit('showModal','".route('dashboard.international-transfer.cc-partners.destroy',$model->id)."','DELETE','x-circle','Delete')"];

                $actions[] = ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="user-check" data-lucide="user-check" class="lucide lucide-user-check w-4 h-4 mr-2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>','isOverlay' => '0','method' => 'GET','route' => route('dashboard.international-transfer.cc-partner-accounts', $value),'action' => 'Accounts'];
                $actions[] = ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="send" data-lucide="send" class="lucide lucide-send w-4 h-4 mr-2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>','isOverlay' => '0','method' => 'GET','route' => route('dashboard.international-transfer.cc-partner-transactions', $value),'action' => 'Transactions'];
                return view('cms::livewire.datatable-actions', ['actions' => $actions])->withUser($row);
            })

        ];
    }

    public static function setFilters()
    {
        return [
            TextFilter::make('first_name')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('first_name', 'like', '%' . $value . '%');
            }),

            TextFilter::make('last_name')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('last_name', 'like', '%' . $value . '%');
            }),

            TextFilter::make('email')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('email', 'like', '%' . $value . '%');
            }),

            TextFilter::make('phone')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('phone', 'like', '%' . $value . '%');
            }),
        ];

    }
}
