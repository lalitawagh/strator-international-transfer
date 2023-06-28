<?php

namespace Kanexy\InternationalTransfer\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Kanexy\InternationalTransfer\Models\CcAccount;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class CcPartnerAccount extends Transaction
{
    public static function setBuilder($workspace_id,$type): Builder
    {
        $id = request()->route('id');
        return CcAccount::query()->where('meta->partner_holder_id',$id)->latest();
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

            Column::make("Name", "name")
                ->searchable()
                ->secondaryHeaderFilter('name'),

            Column::make("Account", "meta->account_number")
                ->searchable()
                ->secondaryHeaderFilter('meta->account_number'),

            Column::make("Sort Code", "meta->routing_code")
                ->searchable()
                ->secondaryHeaderFilter('meta->routing_code'),

            Column::make("Status", "status")->format(function ($value, $model) {
               return ($value == 'enabled') ? 'Active' : 'Inactive';
            })
                ->searchable()
                ->secondaryHeaderFilter('status'),

        ];
    }

    public static function setFilters()
    {
        return [
            TextFilter::make('name')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('meta->partner_holder_id',request()->route('id'))->where('name', 'like', '%' . $value . '%');
            }),

            TextFilter::make('meta->account_number')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('meta->account_number', 'like', '%' . $value . '%');
            }),

            TextFilter::make('meta->routing_code')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('meta->routing_code', 'like', '%' . $value . '%');
            }),

            SelectFilter::make('Status')
            ->options([
                '' => 'All',
                'enabled' => 'Active',
                'disbaled' => 'Inactive',
            ])
            ->filter(function (Builder $builder, string $value) {

                $builder->where('status', $value);
            }),
        ];

    }
}
