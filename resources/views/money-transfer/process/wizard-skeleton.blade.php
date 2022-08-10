@extends('international-transfer::layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' rel='stylesheet' type='text/css'>
@endpush

@section('content')
    <div class="grid grid-cols-12 gap-0 mt-0">
        <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <div class="tab-content">
                        <div id="RequestCard" class="tab-pane grid grid-cols-12 gap-3 mt-0 active" role="tabpanel"
                            aria-labelledby="RequestCard-tab">
                            <div class="intro-y col-span-12 md:col-span-12 mt-0">
                                <!-- BEGIN: Wizard Layout -->
                                <div class="intro-y box sm:py-10 sm:py-0 mt-0">
                                    <div class="flex items-center p-3 border-b border-gray-200 dark:border-dark-5">
                                        <h2 class="font-medium text-base mr-auto">
                                            Money Transfer
                                        </h2>
                                        <div class="ml-auto pos">
                                            <ul class="nav nav-pills w-7/5 bg-slate-100 dark:bg-black/20 rounded-md mx-auto"
                                                role="tablist">
                                                <li id="local-tab" class="nav-item flex-1" role="presentation">
                                                    <a href="{{ route('dashboard.banking.payouts.index', ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]) }}"
                                                        class="nav-link w-full py-1.5 px-2" data-tw-toggle="pill"
                                                        data-tw-target="#local" type="button" role="tab"
                                                        aria-controls="local" aria-selected="true">
                                                        Local
                                                    </a>
                                                </li>
                                                <li id="international-tab" class="nav-item flex-1" role="presentation">
                                                    <a href="{{ route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]) }}"
                                                        class="nav-link w-full py-1.5 px-2 active" data-tw-toggle="pill"
                                                        data-tw-target="#international" type="button" role="tab"
                                                        aria-controls="international" aria-selected="true">
                                                        International
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>



                                    <div
                                        class="relative before:hidden before:lg:block before:absolute before:w-[69%] before:h-[3px] before:top-0 before:bottom-0 before:mt-4 before:bg-slate-100 before:dark:bg-darkmode-400 flex flex-col lg:flex-row justify-center px-5 sm:px-20 mt-8">
                                        <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                                            <button
                                                class="w-10 h-10 rounded-full btn {{ request()->routeIs('dashboard.international-transfer.money-transfer.create') ? 'btn-primary' : 'text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400' }}">1</button>
                                            <div
                                                class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto {{ request()->routeIs('dashboard.international-transfer.money-transfer.create') ? 'font-bold' : 'text-gray-700 dark:text-gray-600' }}">
                                                Amount</div>
                                        </div>

                                        <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                                            <button
                                                class="w-10 h-10 rounded-full btn {{ request()->routeIs('dashboard.international-transfer.money-transfer.beneficiary') ? 'btn-primary' : 'text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400' }}">2</button>
                                            <div
                                                class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto {{ request()->routeIs('dashboard.international-transfer.money-transfer.beneficiary') ? 'font-bold' : 'text-gray-700 dark:text-gray-600' }}">
                                                Beneficiary</div>
                                        </div>
                                        <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                                            <button
                                                class="w-10 h-10 rounded-full btn {{ request()->routeIs('dashboard.international-transfer.money-transfer.payment') ? 'btn-primary' : 'text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400' }}">3</button>
                                            <div
                                                class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto {{ request()->routeIs('dashboard.international-transfer.money-transfer.payment') ? 'font-bold' : 'text-gray-700 dark:text-gray-600' }}">
                                                Payment</div>
                                        </div>
                                        <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                                            <button
                                                class="w-10 h-10 rounded-full btn {{ request()->routeIs('dashboard.international-transfer.money-transfer.preview') || request()->routeIs('dashboard.international-transfer.money-transfer.stripe') ? 'btn-primary' : 'text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400' }}">4</button>
                                            <div
                                                class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto {{ request()->routeIs('dashboard.international-transfer.money-transfer.preview') || request()->routeIs('dashboard.international-transfer.money-transfer.stripe') ? 'font-bold' : 'text-gray-700 dark:text-gray-600' }}">
                                                Preview</div>
                                        </div>

                                        <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                                            <button
                                                class="w-10 h-10 rounded-full btn {{ request()->routeIs('dashboard.international-transfer.money-transfer.showFinal') ? 'btn-primary' : 'text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400' }}">5</button>
                                            <div
                                                class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto {{ request()->routeIs('dashboard.international-transfer.money-transfer.showFinal') ? 'font-bold' : 'text-gray-700 dark:text-gray-600' }}">
                                                Finish</div>

                                            <div
                                                class="relative before:hidden before:lg:block before:absolute before:w-[69%] before:h-[3px] before:top-0 before:bottom-0 before:mt-4 before:bg-slate-100 before:dark:bg-darkmode-400 flex flex-col lg:flex-row justify-center px-5 sm:px-20 gap-3 pb-2 wizard flex flex-wrap lg:flex-row justify-center px-5 mt-5 sm:px-20">
                                                <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                                                    <button
                                                        class="w-10 h-10 rounded-full btn {{ request()->routeIs('dashboard.international-transfer.money-transfer.create') ? 'btn-primary' : 'text-gray-600 bg-gray-200 dark:bg-dark-1' }}">1</button>
                                                    <div
                                                        class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto {{ request()->routeIs('dashboard.international-transfer.money-transfer.create') ? 'font-bold' : 'text-gray-700 dark:text-gray-600' }}">
                                                        Amount</div>
                                                </div>

                                                <div
                                                    class="intro-x lg:text-center flex items-center mt-4 lg:mt-0 sm:mt-0 lg:block flex-1 z-10">
                                                    <button
                                                        class="w-10 h-10 rounded-full btn {{ request()->routeIs('dashboard.international-transfer.money-transfer.beneficiary') ? 'btn-primary' : 'text-gray-600 bg-gray-200 dark:bg-dark-1' }}">2</button>
                                                    <div
                                                        class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto {{ request()->routeIs('dashboard.international-transfer.money-transfer.beneficiary') ? 'font-bold' : 'text-gray-700 dark:text-gray-600' }}">
                                                        Beneficiary</div>
                                                </div>

                                                <div
                                                    class="intro-x lg:text-center flex items-center mt-4 lg:mt-0 sm:mt-0 lg:block flex-1 z-10">
                                                    <button
                                                        class="w-10 h-10 rounded-full btn {{ request()->routeIs('dashboard.international-transfer.money-transfer.payment') ? 'btn-primary' : 'text-gray-600 bg-gray-200 dark:bg-dark-1' }}">3</button>
                                                    <div
                                                        class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto {{ request()->routeIs('dashboard.international-transfer.money-transfer.payment') ? 'font-bold' : 'text-gray-700 dark:text-gray-600' }}">
                                                        Payment</div>
                                                </div>

                                                <div
                                                    class="intro-x lg:text-center flex items-center mt-4 lg:mt-0 sm:mt-0 lg:block flex-1 z-10">
                                                    <button
                                                        class="w-10 h-10 rounded-full btn {{ request()->routeIs('dashboard.international-transfer.money-transfer.preview') || request()->routeIs('dashboard.international-transfer.money-transfer.stripe') ? 'btn-primary' : 'text-gray-600 bg-gray-200 dark:bg-dark-1' }}">4</button>
                                                    <div
                                                        class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto {{ request()->routeIs('dashboard.international-transfer.money-transfer.preview') || request()->routeIs('dashboard.international-transfer.money-transfer.stripe') ? 'font-bold' : 'text-gray-700 dark:text-gray-600' }}">
                                                        Preview</div>
                                                </div>

                                                <div
                                                    class="intro-x lg:text-center flex items-center mt-4 lg:mt-0 sm:mt-0 lg:block flex-1 z-10">
                                                    <button
                                                        class="w-10 h-10 rounded-full btn {{ request()->routeIs('dashboard.international-transfer.money-transfer.showFinal') ? 'btn-primary' : 'text-gray-600 bg-gray-200 dark:bg-dark-1' }}"
                                                        data-tw-target="#copy-button-modal">5</button>
                                                    <div
                                                        class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto {{ request()->routeIs('dashboard.international-transfer.money-transfer.showFinal') ? 'font-bold' : 'text-gray-700 dark:text-gray-600' }}">
                                                        Finish</div>

                                                </div>

                                                <div
                                                    class="wizard__line hidden lg:block w-2/3 bg-gray-200 dark:bg-dark-1 absolute mt-5">
                                                </div>
                                            </div>

                                            @yield('money-transfer-content')

                                        </div>
                                        <!-- END: Wizard Layout -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
