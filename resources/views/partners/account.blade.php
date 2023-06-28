@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="flex items-center p-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        CC Partner Accounts
                    </h2>
                    @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('dashboard.international-transfer.cc-partners.create') }}"
                        class="btn btn-sm btn-primary shadow-md sm:ml-1 sm:-mt-2 sm:mb-0 mb-2 py-2">Create Partner</a>
                    @endif
                </div>

                <div class="datatable-select Livewire-datatable-modal pb-3" attr="datatable-select">
                    <livewire:data-table model='Kanexy\InternationalTransfer\Contracts\CcPartnerAccount'
                        params="" type='cc-partner-account' />
                </div>
            </div>
        </div>
    </div>
    @livewire('confirmation-modal')
@endsection

