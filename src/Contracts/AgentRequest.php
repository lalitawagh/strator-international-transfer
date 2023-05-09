<?php

namespace Kanexy\InternationalTransfer\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class AgentRequest extends Transaction
{
    public static function setBuilder($workspace_id,$type): Builder
    {
        return User::query()->where("type", 'agent')->where('status' ,'!=' ,'approved')->with('membershipUser')->latest();
    }

    public static function setBulkActions()
    {
        return false;
    }

    public static function setPagination()
    {
        return true;
    }

    public static function columns()
    {
        
        return [
            Column::make("Id", "id")->hideIf(true),

            Column::make("First Name", "first_name")->format(function ($value, $model) {
                return view('cms::livewire.link-datatable', ['user' => $value,'route' => route('dashboard.memberships.show', $model->membershipUser->membership_id)]);
            })
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
                $actions[] = ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-circle" data-lucide="check-circle" class="lucide lucide-check-circle w-4 h-4 mr-2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>','isOverlay' => '0','method' => 'GET','route' => route('dashboard.international-transfer.agent-detail', $value),'action' => 'Approve Agent'];
             
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
