<?php

namespace Kanexy\InternationalTransfer\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Kanexy\PartnerFoundation\Core\Models\Transaction;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Column;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardList extends Transaction
{
    public static function setPagination()
    {
        return false;
    }

    public static function setBulkActions()
    {
        return false;
    }

    public static function setBuilder($workspace_id,$type): Builder
    {
        if (!$workspace_id) {
            return Transaction::query()->where("meta->transaction_type", 'money_transfer')->latest()->take(15);
        }

        return Transaction::query()->where("meta->transaction_type", 'money_transfer')->whereWorkspaceId($workspace_id)->latest()->take(15);
    }

    public static function columns()
    {

        return [
            Column::make("Id", "id")->hideIf(true),

            Column::make("Transaction Id", "urn")
                ->sortable()
                ->searchable()
                ->secondaryHeaderFilter('urn'),

            Column::make("Date & Time", "created_at")->format(function($value){
                return Carbon::parse($value)->format('d-m-Y  H:i');
            })
                ->secondaryHeaderFilter('created_at')
                ->sortable(),

            Column::make("Sender name", "meta->sender_name")->format(function ($value) {
                return ucfirst($value);
            })
                ->searchable()
                ->sortable()
                ->secondaryHeaderFilter('meta->sender_name'),

            Column::make("Sending Currency", "meta->base_currency")->format(function ($value) {
                return ucfirst($value);
            })
                ->searchable()
                ->sortable()
                ->secondaryHeaderFilter('meta->base_currency'),

            Column::make("Sending Amount", "amount")->format(function ($value, $model) {
                return '<span class="px-6 py-4 whitespace-nowrap text-sm text-right text-right text-theme-6">'.\Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($model?->amount, $model['meta->base_currency']).'</span>';
            })
                ->searchable()
                ->sortable()
                ->html(),

            Column::make("Receiver name", "meta->second_beneficiary_name")->format(function ($value) {
                return ucfirst($value);
            })
                ->searchable()
                ->sortable()
                ->secondaryHeaderFilter('meta->second_beneficiary_name'),

            Column::make("Receiving Currency", "meta->exchange_currency")->format(function ($value) {
                return ucfirst($value);
            })
                ->searchable()
                ->sortable()
                ->secondaryHeaderFilter('meta->exchange_currency'),

            Column::make("Receiving Amount", "meta->recipient_amount")->format(function ($value, $model) {
                return '<span class="px-6 py-4 whitespace-nowrap text-sm text-right text-right text-success">'.\Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($model['meta->recipient_amount'], $model['meta->exchange_currency']).'</span>';
            })
                    ->searchable()
                    ->sortable()
                    ->html(),

            Column::make("Source", "payment_method")->format(function ($value) {
                return ucfirst($value);
            })
                ->sortable()
                ->searchable()
                ->secondaryHeaderFilter('payment_method'),

            Column::make("Status", "status")->format(function ($value) {
                return ucfirst($value);
            })
                ->searchable()
                ->secondaryHeaderFilter('status')
                ->sortable(),

        ];
    }

    public static function setFilters()
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'All',
                    'draft' => 'Draft',
                    'cancelled' => 'Cancelled',
                    'accepted' => 'Accepted',
                    'completed' => 'Completed',
                    'pending'   => 'Pending',
                ])
                ->filter(function (Builder $builder, string $value) {

                    $builder->where('status', $value);
                }),

            DateFilter::make('Created at')->filter(function (Builder $builder, string $value) {
                $builder->whereDate('created_at', date('Y-m-d', strtotime($value)));
            }),

            TextFilter::make('urn')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('transactions.urn', 'like', '%' . $value . '%');
            }),
            TextFilter::make('meta->sender_name')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('transactions.meta->sender_name', 'like', '%' . $value . '%');
            }),
            TextFilter::make('meta->base_currency')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('transactions.meta->base_currency', 'like', '%' . $value . '%');
            }),
            TextFilter::make('meta->second_beneficiary_name')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('transactions.meta->second_beneficiary_name', 'like', '%' . $value . '%');
            }),
            TextFilter::make('meta->exchange_currency')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('transactions.meta->exchange_currency', 'like', '%' . $value . '%');
            }),
            TextFilter::make('payment_method')->hiddenFromAll()->config(['placeholder' => 'Search', 'maxlength' => '25',])->filter(function (Builder $builder, string $value) {
                $builder->where('transactions.payment_method', 'like', '%' . $value . '%');
            }),


        ];

    }
}
