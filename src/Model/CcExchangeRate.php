<?php

namespace Kanexy\InternationalTransfer\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kanexy\Cms\I18N\Models\Country;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Spatie\Activitylog\LogOptions;

class CcExchangeRate extends Model

{
    use HasFactory;

    protected $fillable = [
        'exchange_from',
        'exchange_to',
        'rate_type',
        'customized_rate',
        'plus_minus',
        'percentage',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('Cc Exchange Rate')->logOnly(['*'])->logOnlyDirty();

    }

    public static function setPagination()
    {
        return true;
    }

    public static function setBulkActions()
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

    public static function setBuilder($type): Builder
    {
        return CcExchangeRate::query()->latest();
    }

    public static function columns()
    {

        return [
            Column::make("Id", "id")->hideIf(true),

            Column::make("Exchange From", "exchange_from")->format(function ($value) {
                $country = Country::find($value);
                return $country ? ucfirst($country->name) : null;
            })
                ->sortable()
                ->searchable()
                ->secondaryHeaderFilter('exchange_from'),

                Column::make("Exchange To", "exchange_to")->format(function ($value) {
                    $country = Country::find($value);

                    return $country ? ucfirst($country->name) : null;
                })
                    ->sortable()
                    ->searchable()
                    ->secondaryHeaderFilter('exchange_to'),

                Column::make("Rate Type", "rate_type")
                    ->sortable()
                    ->searchable()
                    ->secondaryHeaderFilter('rate_type'),

                Column::make("Customized Rate", "customized_rate")
                    ->sortable()
                    ->searchable()
                    ->secondaryHeaderFilter('customized_rate'),

                Column::make("plus minus", "plus_minus")
                ->sortable()
                ->searchable()
                ->secondaryHeaderFilter('plus_minus'),

                Column::make("Percentage", "percentage")
                ->sortable()
                ->searchable()
                ->secondaryHeaderFilter('percentage'),

            Column::make('Actions','id')->format(function($value, $model, $row) {
                $actions = [];
                $actions[] = ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit-2" data-lucide="edit-2" class="lucide lucide-edit-2 w-4 h-4 mr-2"><path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>','isOverlay' => '0','method' => 'GET','route' => route('dashboard.international-transfer.exchange-rate.edit',$value),'action' => 'Edit'];
                $actions[] = ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash" data-lucide="trash" class="lucide lucide-trash w-4 h-4 mr-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path></svg>','isOverlay' => 'true','method' => 'GET','action' => "Delete",
                'route' => "Livewire.emit('showModal','".route('dashboard.international-transfer.exchange-rate.destroy',$model->id)."','DELETE','x-circle','Delete')"];

                return view('cms::livewire.datatable-actions', ['actions' => $actions])->withUser($row);
            })

        ];
    }

    public static function setFilters()
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'All',
                    'active' => 'Active',
                    'inactive' => 'InActive',
                ])
                ->filter(function (Builder $builder, string $value) {

                    $builder->where('status', $value);
                }),

            TextFilter::make('name')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('name', 'like', '%' . $value . '%');
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
