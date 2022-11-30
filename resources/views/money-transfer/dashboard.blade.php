@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    {{-- <div class="grid grid-cols-3 gap-4">
        <div>
            @include('international-transfer::widget.dashboard-piechart')
        </div>
    </div>
    <br> --}}
    <div class="intro-y col-span-12 lg:col-span-12">
        <div class="gap-4">
            <div class="intro-y col-span-12">
                <div class="box shadow-lg  p-5">
                        <div class="text-lg font-medium mr-auto mt-2">Transactions</div>
                        <div class="Livewire-datatable-modal pb-3">
                            <livewire:data-table model='Kanexy\InternationalTransfer\Contracts\DashboardList' params="{{$workspace?->id}}" type="money-transfer"/>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

