@extends('international-transfer::configuration.skeleton')

@section('title', 'Exchange Rate')

@section('create-button')
        @can(\Kanexy\InternationalTransfer\Policies\ExchangeRatePolicy::CREATE,
            \Kanexy\InternationalTransfer\Contracts\ExchangeRateConfiguration::class)
            <a id="CreateNew" href="{{ route('dashboard.international-transfer.exchange-rate.create') }}"
                class="btn btn-sm btn-primary shadow-md">Create New</a>
        @endcan
@endsection

@section('config-content')
    <div class="configuration-container w-screen">
        <div class="grid grid-cols-8 gap-0">
            <div class="intro-y box col-span-5 xxl:col-span-12 bg-gray-100 p-4">
                <div
                    class="overflow-x-auto overflow-y-hidden sm:flex gap-2 gap-2 flex-wrap items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5 text-right">

                </div>
                <div class="datatable-select Livewire-datatable-modal pb-3" attr="datatable-select">
                     <livewire:data-table model='Kanexy\InternationalTransfer\Model\CcExchangeRate' params="" type="exchange-rate" />
                </div>
            </div>
        </div>
    </div>
@endsection
