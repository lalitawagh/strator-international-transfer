<?php

namespace Kanexy\InternationalTransfer\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class AgentUsers extends Transaction
{
    public static function setBuilder($workspace_id,$type): Builder
    {
        $workspace = Workspace::where("ref_type", 'agent')->where("ref_id", $workspace_id)->pluck('admin_id');
        
        return User::query()->whereIn('id',$workspace->toArray())->latest();
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
