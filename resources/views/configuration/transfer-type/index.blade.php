@push('styles')
<style>
@media (max-width: 580px) {
    .asset-create {
        display: flex;
    }
}
@media (max-width: 579px) {
    .asset-create {
        display: block;
        margin-top: 10px;
    }
}
</style>
@endpush
@extends("internation-transfer::configuration.skeleton")

@section('title', 'Asset Class')

@section("config-content")
<div class="configuration-container w-screen">
    <div class="grid grid-cols-12 gap-6">
        <div class="intro-y box col-span-12 xxl:col-span-12">
            <div class="asset-create sm:flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <div class="breadcrumb mr-auto hidden sm:flex">
                    <a href="">Wallet</a><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right breadcrumb__icon breadcrumb__icon"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    <a href="" class="">Configuration</a><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right breadcrumb__icon breadcrumb__icon"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    <a href="" class="breadcrumb--active">Asset Class</a>
                </div>
                <div>
                    <a href="{{ route('dashboard.wallet.asset-class.create') }}" class="btn btn-sm btn-primary shadow-md">Create New</a>
                </div>
            </div>
            <div class="p-5">
                <div class="overflow-x-auto box">
                    <table class="table">
                        <thead>
                            <tr class="bg-gray-300 dark:bg-dark-1">
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Name</th>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Image</th>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Status</th>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp

                        </tbody>
                    </table>
                </div>
                <div class="my-2">

                </div>
             </div>
        </div>
    </div>
</div>
@endsection
