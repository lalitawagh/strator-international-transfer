@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="flex items-center p-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        CC Partners
                    </h2>
                </div>

                <div class="datatable-select Livewire-datatable-modal pb-3" attr="datatable-select">
                    <livewire:data-table model='Kanexy\InternationalTransfer\Contracts\CcPartners'
                        params="" type='cc-partners' />
                </div>
            </div>
        </div>
    </div>
    @livewire('confirmation-modal')
@endsection

