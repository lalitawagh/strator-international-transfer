@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="flex items-center p-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Money Transfer
                    </h2>
                    @if(auth()->user()->isSuperAdmin())
                    <a id="assetClassCreateNew" href="{{ route('dashboard.international-transfer.money-transfer.index', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]])}}"
                    class="btn btn-sm btn-primary shadow-md"> Money Transfer Transactions</a> 
                    @endif
                    @if (auth()->user()->isSubscriber())
                        @can(\Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy::CREATE,
                            \Kanexy\InternationalTransfer\Contracts\MoneyTransfer::class)
                            <a id="MoneyTransfer"
                                href="{{ route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]) }}"
                                class="btn btn-sm btn-primary sm:ml-2 py-2 sm:mb-2 mb-2">Money
                                Transfer</a>
                        @endcan
                    @endif
                </div>

                <div class="Livewire-datatable-modal pb-3">
                    <livewire:data-table model='Kanexy\InternationalTransfer\Contracts\ArchivedMoneyTransfer'
                        params="{{ $workspace?->id }}" type='money-transfer' />
                </div>
            </div>
        </div>
    </div>
@endsection