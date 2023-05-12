@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="flex items-center p-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Agent Users
                    </h2>
                </div>

                <div class="Livewire-datatable-modal pb-3">
                    <livewire:data-table model='Kanexy\InternationalTransfer\Contracts\AgentUsers'
                        params="{{ $user_id }}" type='agent-users' />
                </div>
            </div>
        </div>
    </div>
@endsection