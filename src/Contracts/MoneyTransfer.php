<?php

namespace Kanexy\InternationalTransfer\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Kanexy\InternationalTransfer\Exports\MoneyTransferExport;
use Kanexy\PartnerFoundation\Banking\Exports\TransactionExport;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Traits\InteractsWithUrn;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use PDF;

class MoneyTransfer extends Transaction
{
    public static function setBuilder($workspace_id,$type): Builder
    {
         if (!$workspace_id) {
            return Transaction::query()->where("meta->transaction_type", 'money_transfer')->latest();
         }

         return Transaction::query()->where("meta->transaction_type", 'money_transfer')->whereWorkspaceId($workspace_id)->latest();
    }

    public static function downloadExcel($records)
    {
        return Excel::download(new MoneyTransferExport($records), 'transactions.xlsx');
    }

    public static function downloadCsv($records)
    {
        return Excel::download(new MoneyTransferExport($records), 'transactions.csv');
    }

    public static function downloadPdf($records)
    {
        $transactions = collect();
        foreach ($records as $record) {
            $transactions->push(Transaction::find($record));
        }

        $account = auth()->user()->workspaces()->first()?->account()->first();
        $user = Auth::user();
        $view = PDF::loadView('international-transfer::money-transfer.transactionlistpdf', compact('transactions','account','user'))
            ->setPaper(array(0, 0, 1000, 800), 'landscape')
            ->output();

        return response()->streamDownload(fn () => print($view), "transactionslist.pdf");
    }

    public static function columns()
    {

        return [
            Column::make("Id", "id")->hideIf(true),

            Column::make("Transaction Id", "urn")
                ->sortable()->format(function ($value, $model) {
                    return view('cms::livewire.datatable-link', ['user' => $value, 'overlay' => "Livewire.emit('showTransactionDetail', $model->id);Livewire.emit('showTransactionAttachment', $model->id );Livewire.emit('showTransactionLog', $model->id);"]);
                })
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
                return '<span class="px-6 py-4 whitespace-nowrap text-sm text-right text-right text-success">'.\Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($model?->amount, $model['meta->exchange_currency']).'</span>';
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

            Column::make('Actions','id')->format(function($value, $model, $row) {
                $actions =[];
                if (\Illuminate\Support\Facades\Auth::user()->isSuperadmin()){
                    if ($model->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::CANCELLED){
                        if ($model->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED){
                            $actions[] = ['icon' => '<x-feathericon-check-circle class="w-4 h-4 mr-2" />','isOverlay' => '0','route' => route('dashboard.international-transfer.money-transfer.transferCompleted', $value),'action' => 'Completed'];

                        }
                        if ($model->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::ACCEPTED &&
                            $model->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED){
                            $actions[] = ['isOverlay' => '0','route' => route('dashboard.international-transfer.money-transfer.transferAccepted', $value),'action' => 'Accepted'];

                        }
                        if ($model->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::ACCEPTED &&
                            $model->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::PENDING &&
                            $model->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED){
                                $actions[] = ['isOverlay' => '0','route' => route('dashboard.international-transfer.money-transfer.transferPending', $value),'action' => 'Pending'];
                        }
                    }
                }
                $actions[] = ['isOverlay' => 'true','action' => 'Track','route' => "Livewire.emit('showTransactionTrack', $model->id);"];
                $actions[] = ['isOverlay' => 'true','action' => 'Show','route' => "Livewire.emit('showTransactionDetail',$model->id);Livewire.emit('showTransactionLog', $model->id);Livewire.emit('showTransactionAttachment', $model->id);"];

                return view('cms::livewire.datatable-actions', ['actions' => $actions])->withUser($row);
            }),

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
