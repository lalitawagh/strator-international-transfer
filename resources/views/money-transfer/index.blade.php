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
                </div>

                <div class="p-5">
                    <div class="grid grid-cols-12  gap-3">
                        <div class="col-span-12 lg:col-span-12 xxl:col-span-12 mt-0">
                            <div class="grid grid-cols-12 gap-3">
                                <!-- BEGIN: -->
                                <div class="intro-y col-span-12 lg:col-span-12 xxl:col-span-12 p-0">
                                    <div id="1" class="tab-pane grid grid-cols-12 gap-3 pt-0" role="tabpanel"
                                        aria-labelledby="1-tab">
                                        <div class="active col-span-12 mt-0 w-full" role="tabpanel" id="k-wallet"
                                            aria-labelledby="k-wallet-tab">

                                            <div class="intro-y  overflow-x-auto overflow-y-hidden  sm:mt-3 sm:mt-0">

                                                <div
                                                    class="w-full flex-wrap sm:flex sm:items-center items-center p-2 sm:py-0 border-b border-gray-200 dark:border-dark-5 justify-end">
                                                    <div class="w-auto nav nav-tabs mr-auto hidden sm:flex" role="tablist">
                                                        <a id="work-in-progress-mobile-new-tab" data-toggle="tab"
                                                            data-target="#work-in-progress-new" href="javascript:;"
                                                            class="py-2 ml-0 active" role="tab" aria-selected="true">ALL</a>
                                                    </div>
                                                    <div class="flex flex-wrap gap-2 items-center md:ml-auto mb-2">
                                                        <div
                                                            class="col-span-6 sm:col-span-3 lg:col-span-2 xl:col-span-1 search  sm:block lg:mr-2 lg:ml-auto">
                                                            <input list="browsers" name="browser" id="browser"
                                                                placeholder="Search"
                                                                class="search__input form-control border-transparent placeholder-theme-13">
                                                            <i data-feather="search"
                                                                class="search__icon dark:text-gray-300"></i>
                                                        </div>
                                                        <div class="dark:text-gray-300">1 of 50</div>
                                                        <a href="javascript:;"
                                                            class="w-5 h-5 ml-1 flex items-center justify-center dark:text-gray-300">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-chevron-left w-5 h-5">
                                                                <polyline points="15 18 9 12 15 6"></polyline>
                                                            </svg> </a>
                                                        <a href="javascript:;"
                                                            class="w-5 h-5 lg:mr-2 flex items-center justify-center dark:text-gray-300">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-chevron-right w-5 h-5">
                                                                <polyline points="9 18 15 12 9 6"></polyline>
                                                            </svg> </a>

                                                        <a href="#"
                                                            class="ml-auto w-5 h-5 ml-2 mr-2 flex items-center justify-center dark:text-gray-300">
                                                            <i class="w-4 h-4" data-feather="list"></i></a>
                                                        <a href="#"
                                                            class="w-5 h-5 mr-2 flex items-center justify-center dark:text-gray-300">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                viewBox="0 0 20 20" fill="#c1c4c9">
                                                                <path
                                                                    d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                                            </svg> </a>


                                                    </div>

                                                    <div class="dr-btn flex sm:flex mt-5 sm:mt-0 mb-2"
                                                        style="">

                                                        <div class="dropdown sm:w-auto ml-2 sm:ml-0 mr-2">
                                                            <button
                                                                class="dropdown-toggle btn btn-sm py-2 btn-outline-secondary w-full sm:w-auto"
                                                                aria-expanded="false"><i data-feather="filter"
                                                                    class="w-4 h-4 ml-auto sm:ml-0 mr-2"></i> Filter <i
                                                                    data-feather="chevron-down"
                                                                    class="w-4 h-4 ml-auto sm:ml-2"></i> </button>
                                                            <div class="dropdown-menu lg:w-40 filter-dropbox">
                                                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                                    <a id="tabulator-export-xlsx" href="javascript:;"
                                                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                        Add Custom Filter </a>
                                                                    <form class="filter-form relative">
                                                                        <div class="form mb-1">
                                                                            <select data-search="true"
                                                                                class="tom-select w-full form-control-sm mt-2">
                                                                                <option value="1">Column Name</option>
                                                                                <option value="2">Column Name 1</option>
                                                                                <option value="3">Column Name 2</option>
                                                                            </select>
                                                                            <span class="float-right ml-2 absolute plus"
                                                                                style="margin:0;">
                                                                                <a href="javascript:;"><i
                                                                                        data-feather="trash-2"
                                                                                        class="w-4 h-4 mr-2"></i></a>
                                                                            </span>
                                                                        </div>
                                                                        <div class="form mb-1">
                                                                            <select data-search="true"
                                                                                class="tom-select w-full form-control-sm mt-2">
                                                                                <option value="1">Action is true</option>
                                                                                <option value="2">Action is false</option>
                                                                            </select>
                                                                        </div>
                                                                    </form>
                                                                    <div class="flex mt-3">
                                                                        <div class="w-full px-2">
                                                                            <div class="form-inline">
                                                                                <button type="submit"
                                                                                    class="btn btn-elevated-primary btn-sm mr-1"><i
                                                                                        data-feather="file-text"
                                                                                        class="w-5 h-5 mr-1"></i>
                                                                                    Apply</button>
                                                                                <a href="javascript:void(0);"
                                                                                    class="btn btn-secondary btn-sm mr-1"><i
                                                                                        data-feather="plus-circle"
                                                                                        class="w-5 h-5 mr-1"></i> Add a
                                                                                    condition</a>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button id="tabulator-print"
                                                            class="w-full btn btn-sm py-2 btn-outline-secondary sm:w-auto mr-2">
                                                            <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print
                                                        </button>
                                                        <div class="dropdown sm:w-auto">
                                                            <button
                                                                class="dropdown-toggle btn btn-sm py-2 btn-outline-secondary w-full sm:w-auto"
                                                                aria-expanded="false"> Export <i data-feather="chevron-down"
                                                                    class="w-4 h-4 ml-auto sm:ml-2"></i> </button>
                                                            <div class="dropdown-menu w-40">
                                                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                                    <a id="tabulator-export-xlsx" href="javascript:;"
                                                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                        <i data-feather="file-text"
                                                                            class="w-4 h-4 mr-2"></i> Export XLSX </a>
                                                                    <a id="tabulator-export-html" href="javascript:;"
                                                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                        <i data-feather="file-text"
                                                                            class="w-4 h-4 mr-2"></i> Export PDF </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    @if (\Illuminate\Support\Facades\Auth::user()->isSubscriber())
                                                        <a href="{{ route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]) }}"
                                                            class="btn btn-sm btn-primary sm:ml-2 py-2 sm:mb-2 mb-2">Money
                                                            Transfer</a>
                                                    @endif
                                                </div>
                                                <!-- BEGIN: HTML Table Data -->
                                                <div class="intro-y p-3 mt-0">
                                                    <div class=" overflow-x-auto overflow-y-hidden">
                                                        <!-- <div id="tabulator" class="mt-5 table-report table-report--tabulator"></div> -->

                                                        <table id="tableID"
                                                            class="shroting display table table-report -mt-2">
                                                            <thead class="short-wrp">
                                                                <tr>
                                                                    <th>
                                                                        <div class="form-check mt-0 border-gray-400">
                                                                            <input id="checkbox-switch-1"
                                                                                class="form-check-input" type="checkbox"
                                                                                value="">
                                                                            <label class="form-check-label"
                                                                                for="checkbox-switch-1"></label>
                                                                        </div>
                                                                    </th>

                                                                    <th class="whitespace-nowrap text-left">
                                                                        Transaction ID
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>

                                                                    </th>
                                                                    <th class="whitespace-nowrap text-left">
                                                                        Date & Time
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>
                                                                    </th>
                                                                    <th class="whitespace-nowrap text-left">
                                                                        Sender Name
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>
                                                                    </th>
                                                                    <th class="whitespace-nowrap text-left">
                                                                        Sending Currency
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>
                                                                    </th>
                                                                    <th class="whitespace-nowrap text-left">
                                                                        Sending Amount
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>
                                                                    </th>
                                                                    <th class="whitespace-nowrap text-left">
                                                                        Receiver Name
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>
                                                                    </th>

                                                                    <th class="whitespace-nowrap text-left">
                                                                        Receiving Currency
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>
                                                                    </th>
                                                                    <th class="whitespace-nowrap text-left">
                                                                        Receiving Amount
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>
                                                                    </th>
                                                                    <th class="whitespace-nowrap text-left">
                                                                        Payment Method
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>
                                                                    </th>
                                                                    {{-- <th class="whitespace-nowrap text-left">
                                                                        Amount
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>
                                                                    </th> --}}
                                                                    <th class="whitespace-nowrap text-left">
                                                                        Status
                                                                        <span class="flex short-icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 up" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 down" fill="#c1c4c9"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                                                            </svg>
                                                                        </span>
                                                                    </th>
                                                                    <th class="flex" style="">Action
                                                                    </th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($transactions as $transaction)
                                                                    <tr>
                                                                        <td class="whitespace-nowrap text-left">
                                                                            <div class="form-check mt-0 border-gray-400">
                                                                                <input id="checkbox-switch-1"
                                                                                    class="form-check-input"
                                                                                    type="checkbox" value="">
                                                                                <label class="form-check-label"
                                                                                    for="checkbox-switch-1"></label>
                                                                            </div>
                                                                        </td>
                                                                        <td class="whitespace-nowrap text-left"> <a
                                                                                href="javascript:void(0);"
                                                                                onclick="Livewire.emit('showTransactionDetail', {{ $transaction->getKey() }});Livewire.emit('showTransactionLog', {{ $transaction->getKey() }});Livewire.emit('showTransactionAttachment', {{ $transaction->getKey() }});"

                                                                                style="color:#70297d !important;">{{ $transaction->urn }}</a>
                                                                        </td>
                                                                        <td class="whitespace-nowrap text-left">
                                                                            {{ $transaction->getLastProcessDateTime()->format($defaultDateFormat . ' ' . $defaultTimeFormat) }}
                                                                        </td>
                                                                        <td class="whitespace-nowrap text-left">
                                                                            {{ $transaction->meta['sender_name'] }}</td>
                                                                        <td class="whitespace-nowrap text-center">
                                                                            {{ $transaction->meta['base_currency'] }}
                                                                        </td>
                                                                        <td class="whitespace-nowrap text-right text-theme-6">
                                                                            {{ \Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($transaction->amount,$transaction->meta['base_currency']) }}
                                                                        </td>
                                                                        <td class="whitespace-nowrap text-left">
                                                                            {{ $transaction->meta['second_beneficiary_name'] }}
                                                                        </td>

                                                                        <td class="whitespace-nowrap text-center">
                                                                            {{ $transaction->meta['exchange_currency'] }}
                                                                        </td>
                                                                        <td class="whitespace-nowrap text-right text-theme-9">
                                                                           @isset($transaction->meta['recipient_amount'])
                                                                           {{ \Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($transaction->meta['recipient_amount'],$transaction->meta['exchange_currency']) }}
                                                                           @endisset
                                                                        </td>
                                                                        <td class="whitespace-nowrap text-left">
                                                                            {{ trans('international-transfer::configuration.' . $transaction->payment_method) }}
                                                                        </td>
                                                                        {{-- <td class="whitespace-nowrap text-right @if ($transaction->type === 'debit') text-theme-6 @else text-theme-9 @endif">
                                                                            {{ \Kanexy\PartnerFoundation\Core\Helper::getFormatAmount($transaction->amount) }}
                                                                        </td> --}}

                                                                        <td class="whitespace-nowrap text-left">
                                                                            {{ trans('international-transfer::configuration.' . $transaction->status) }}
                                                                        </td>

                                                                            <td class="table-report__action"
                                                                                style="box-shadow: none;">
                                                                                <div class="dropdown"
                                                                                    style="display: flex; justify-content: center;left: 0;right: 0;margin: 0 auto;">
                                                                                    <a class="dropdown-toggle w-5 h-5 block"
                                                                                        href="javascript:;"
                                                                                        aria-expanded="false">
                                                                                        <x-feathericon-settings
                                                                                            class="w-5 h-5 text-gray-600" />
                                                                                    </a>
                                                                                    <div class="dropdown-menu w-40">
                                                                                        <div
                                                                                            class="dropdown-menu__content box p-2">
                                                                                            @if (\Illuminate\Support\Facades\Auth::user()->isSuperadmin())
                                                                                                @if ($transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::CANCELLED)
                                                                                                    @if ($transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED)
                                                                                                    <a href="{{ route('dashboard.international-transfer.money-transfer.transferCompleted', $transaction->getKey()) }}"
                                                                                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-green-200 dark:hover:bg-dark-2 rounded-md">
                                                                                                        <x-feathericon-check-circle
                                                                                                            class="w-4 h-4 mr-1" />
                                                                                                        Completed
                                                                                                    </a>
                                                                                                    @endif
                                                                                                    @if ($transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::ACCEPTED && $transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED)
                                                                                                    <a href="{{ route('dashboard.international-transfer.money-transfer.transferAccepted', $transaction->getKey()) }}"
                                                                                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-orange-200 dark:hover:bg-dark-2 rounded-md">
                                                                                                        <x-feathericon-check
                                                                                                            class="w-4 h-4 mr-1" />
                                                                                                        Accepted
                                                                                                    </a>
                                                                                                    @endif
                                                                                                    @if ($transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::ACCEPTED && $transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::PENDING && $transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED)
                                                                                                    <a href="{{ route('dashboard.international-transfer.money-transfer.transferPending', $transaction->getKey()) }}"
                                                                                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-yellow-200 dark:hover:bg-dark-2 rounded-md">
                                                                                                        <x-feathericon-alert-circle
                                                                                                            class="w-4 h-4 mr-1" />
                                                                                                        Pending
                                                                                                    </a>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @endif
                                                                                            <a href="javascript:void(0)" onclick="Livewire.emit('showTransactionTrack', {{ $transaction->getKey() }});"  data-toggle="modal" data-target="#superlarge-slide-over-size-preview"
                                                                                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-blue-200 dark:hover:bg-dark-2 rounded-md">
                                                                                                <x-feathericon-navigation-2
                                                                                                    class="w-4 h-4 mr-1" />
                                                                                                Track
                                                                                            </a>
                                                                                            <a href="javascript:void(0)"  href="javascript:void(0);"
                                                                                            onclick="Livewire.emit('showTransactionDetail', {{ $transaction->getKey() }});Livewire.emit('showTransactionLog', {{ $transaction->getKey() }});Livewire.emit('showTransactionAttachment', {{ $transaction->getKey() }});"
                                                                                              class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-blue-200 dark:hover:bg-dark-2 rounded-md">
                                                                                                <x-feathericon-eye
                                                                                                    class="w-4 h-4 mr-1" />
                                                                                                Show
                                                                                            </a>
                                                                                            {{-- <a href="{{ route('') }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-red-200 dark:hover:bg-dark-2 rounded-md"> <x-feathericon-x-circle class="w-4 h-4 mr-1" /> Cancelled </a> --}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>

                                                                    </tr>
                                                                @endforeach
                                                            </tbody>

                                                        </table>

                                                    </div>
                                                </div>
                                                <!-- END: HTML Table Data -->

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="subscription-modal" class="modal modal-slide-over z-50" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header p-3">
                    <h2 class="text-lg font-medium mr-auto">Transfer Details</h2>

                    <a class="close intro-x cursor-pointer w-8 h-8 flex items-center justify-center rounded-full bg-theme-6 text-white ml-2 tooltip"
                        data-dismiss="modal"> <i data-feather="x" class="w-3 h-3"></i> </a>
                </div>


                <div class="modal-body pt-2">
                    <div class="pr-0 border-b border-gray-200 dark:border-dark-5">
                        <div class="p-0">
                            <div class="pos__tabs nav nav-tabs gap-2" role="tablist">
                                <a id="Overview-tab" data-toggle="tab" data-target="#Overview" href="javascript:;"
                                    class="sm:mr-8 py-2 text-center active" role="tab" aria-controls="Overview"
                                    aria-selected="true">Overview</a>
                                <a id="Notes-tab" data-toggle="tab" data-target="#Notes" href="javascript:;"
                                    class="sm:mr-8 py-2 text-center" role="tab" aria-controls="Notes"
                                    aria-selected="false">Notes</a>
                                <a id="Attachments-tab" data-toggle="tab" data-target="#Attachments" href="javascript:;"
                                    class="sm:mr-8 py-2 text-center" role="tab" aria-controls="Attachments"
                                    aria-selected="false">Attachments</a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content py-3">

                        <div id="Overview" class="tab-pane active " role="tabpanel" aria-labelledby="Overview-tab">
                            <div class="form-inline flex float-right">
                                <div  class="edit-transaction cursor-pointer intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-2 tooltip">
                                    <i data-feather="edit" class="w-3 h-3"></i>
                                </div>
                                <a class="save-transaction cursor-pointer intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 tooltip">
                                    <i data-feather="save" class="w-3 h-3"></i> </a>
                                <a class="intro-x w-8 h-8 cursor-pointer  flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 tooltip"
                                    title="Download PDF" id="create_pdf"> <i data-feather="download" class="w-3 h-3"></i> </a>
                            </div>
                            <div class="clearfix"></div>
                            @livewire('transaction-detail-component')
                        </div>

                        <div id="Notes" class="tab-pane" role="tabpanel" aria-labelledby="Notes-tab">
                            @livewire('transaction-log-component')
                        </div>

                        <div id="Attachments" class="tab-pane" role="tabpanel" aria-labelledby="Attachments-tab">
                            @livewire('transaction-attachment-component')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="superlarge-slide-over-size-preview" class="modal modal-slide-over" tabindex="-1" aria-hidden="true" style="padding-left: 0px;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h2 class="font-medium text-base mr-auto">
                        Transaction Activity
                    </h2>
                </div>
                <div class="modal-body">
                    @livewire('transaction-track-component')

                </div>
            </div>
        </div>
    </div>

@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
@push('scripts')
    <script>
        $('#create_pdf').click(function() {
            var currentPosition = document.getElementById("Overview").scrollTop;
            var w = document.getElementById("Overview").offsetWidth;
            var h = document.getElementById("Overview").offsetHeight;
            document.getElementById("Overview").style.height = "800";

            html2canvas(document.getElementById("Overview"), {
                useCORS: true,
                background: '#fff',
                dpi: 300, // Set to 300 DPI
                scale: 3, // Adjusts your resolution
                onrendered: function(canvas) {
                    var img = canvas.toDataURL("image/png", 1);
                    var doc = new jsPDF('L', 'px', [w, h]);
                    doc.addImage(img, 'PNG', 0, 0, w, h);
                    doc.save('transaction-invoice.pdf');
                }
            });

            document.getElementById("Overview").scrollTop = currentPosition;
        });

        window.addEventListener('show-transaction-detail-modal', event => {
            cash("#subscription-modal").modal("show");
        });
    </script>
@endpush
