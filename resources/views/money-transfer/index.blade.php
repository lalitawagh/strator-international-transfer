@extends('international-transfer::layouts.master')

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
                                                class="flex-wrap sm:flex items-center p-2 sm:py-0 border-b border-gray-200 dark:border-dark-5">
                                                <div class="nav nav-tabs mr-auto hidden sm:flex" role="tablist">
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
                                                    <a href="{{ route('design.email-template') }}"
                                                        class="w-5 h-5 mr-2 flex items-center justify-center dark:text-gray-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            viewBox="0 0 20 20" fill="#c1c4c9">
                                                            <path
                                                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                                        </svg> </a>


                                                </div>

                                                <div class="dr-btn flex sm:flex mt-5 sm:mt-0 mb-2" style="margin-top:-6px;">

                                                    <div class="dropdown sm:w-auto mr-2">
                                                        <button
                                                            class="dropdown-toggle btn btn-sm py-2 btn-outline-secondary w-full sm:w-auto"
                                                            aria-expanded="false"><i data-feather="filter"
                                                                class="w-4 h-4 ml-auto sm:ml-0 mr-2"></i> Filter <i
                                                                data-feather="chevron-down"
                                                                class="w-4 h-4 ml-auto sm:ml-2"></i> </button>
                                                        <div class="dropdown-menu w-40 filter-dropbox">
                                                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                                <a id="tabulator-export-xlsx" href="javascript:;"
                                                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                    Add Custom Filter </a>
                                                                <form class="filter-form relative">
                                                                    <div class="form mb-1">
                                                                        <select data-search="true"
                                                                            class="tail-select w-full form-control-sm mt-2">
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
                                                                            class="tail-select w-full form-control-sm mt-2">
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
                                                <a href="{{ route('dashboard.international-transfer.money-transfer.create',['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]) }}" class="btn btn-sm btn-primary sm:ml-2 -mt-1 sm:mb-2">Money Transfer</a>
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
                                                                    <div class="form-check mt-1 border-gray-400">
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
                                                                    Wallet
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
                                                                    Debit
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
                                                                    Credit
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
                                                                    Balance
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
                                                                <th class="whitespace-nowrap text-left">
                                                                    Reference
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
                                                            <tr>
                                                                <td class="whitespace-nowrap text-left">
                                                                    <div class="form-check mt-1 border-gray-400">
                                                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                                                        <label class="form-check-label" for="checkbox-switch-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td class="whitespace-nowrap text-left">22022022955974</td>
                                                                <td class="whitespace-nowrap text-left">22-02-2022 06:03</td>
                                                                <td class="whitespace-nowrap text-left">Card holder</td>
                                                                <td class="whitespace-nowrap text-left">vivek tiwari</td>
                                                                <td class="whitespace-nowrap text-left">GITTO Coin</td>
                                                                <td class="whitespace-nowrap text-left">-</td>
                                                                <td class="whitespace-nowrap text-left">...</td>
                                                                <td class="whitespace-nowrap text-left"> G 4.08 </td>
                                                                <td class="whitespace-nowrap text-left">Accepted</td>
                                                                <td class="whitespace-nowrap text-left">g to u 10</td>
                                                                <td class="table-report__action" style="box-shadow: none;">
                                                                    <div class="dropdown" style="display: flex; justify-content: center;left: 0;right: 0;margin: 0 auto;">
                                                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <x-feathericon-settings class="w-5 h-5 text-gray-600" /> </a>
                                                                        <div class="dropdown-menu w-40">
                                                                            <div class="dropdown-menu__content box p-2">
                                                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#subscription-modal" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <x-feathericon-eye class="w-4 h-4 mr-1" /> Show </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                {{-- <td>
                                                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#subscription-modal" class="whitespace-nowrap flex items-center p-2 transition duration-300 ease-in-out dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                    <i data-feather="eye" class="w-4 h-4 mr-2"></i> View Invoice
                                                                    </a>
                                                                </td> --}}
                                                            </tr>
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

            <div class="modal-header p-5">
                <h2 class="text-lg font-medium mr-auto">Transfer Details</h2>
                <div class="edit-transaction cursor-pointer intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-2 tooltip"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit w-3 h-3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> </div>
                <a class="save-transaction cursor-pointer intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 tooltip"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save w-3 h-3"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg> </a>
                <a class="close intro-x cursor-pointer w-8 h-8 flex items-center justify-center rounded-full bg-theme-6 text-white ml-2 tooltip" data-dismiss="modal"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x w-3 h-3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </a>
                <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-2 tooltip" title="Share"> <i data-feather="share-2" class="w-3 h-3"></i> </a>
                <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 tooltip" title="Download PDF"> <i data-feather="share" class="w-3 h-3"></i> </a>
            </div>


            <div class="modal-body">
                <div class="pr-0 border-b border-gray-200 dark:border-dark-5">
                    <div class="p-0">
                        <div class="pos__tabs nav nav-tabs gap-2" role="tablist">
                            <a id="Overview-tab" data-toggle="tab" data-target="#Overview" href="javascript:;" class="sm:mr-8 py-2 text-center active" role="tab" aria-controls="Overview" aria-selected="true">Overview</a>
                            <a id="InvoiceHistory-tab" data-toggle="tab" data-target="#InvoiceHistory" href="javascript:;" class="sm:mr-8 py-2 text-center" role="tab" aria-controls="InvoiceHistory" aria-selected="false">Invoice History</a>
                            <a id="RecentActivities-tab" data-toggle="tab" data-target="#RecentActivities" href="javascript:;" class="sm:mr-8 py-2 text-center" role="tab" aria-controls="RecentActivities" aria-selected="false">Recent Activities</a>
                            <a id="Admin-tab" data-toggle="tab" data-target="#Admin" href="javascript:;" class="sm:mr-8 py-2 text-center" role="tab" aria-controls="Admin" aria-selected="false">Admin</a>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="grid grid-cols-12 gap-4 mt-0">
                        <div class="col-span-12 lg:col-span-4 xxl:col-span-3 bg-gray-400 mt-5 px-3 pb-5">
                            <h3 class="font-medium text-bace pt-5">Test</h3>
                            <div class="mb-2 box flex flex-col lg:flex-row items-center px-0 py-2 border-b border-gray-200 dark:border-dark-5">
                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                    <img alt="rounded-full" class="" src="../../dist/images/icons/2.png">
                                </div>
                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                    <a href="" class="font-medium">Bank</a>
                                    <div class="text-gray-600 text-xs mt-0.5">vivektiwari287@gmail.com</div>
                                </div>

                            </div>
                            <div id="faq-accordion-1" class="box accordion accordion-boxed px-2 py-2">
                                <div class="accordion-item">
                                    <div id="faq-accordion-content-1" class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-1" aria-expanded="true" aria-controls="faq-accordion-collapse-1"> SENDER ACCOUNT </button>
                                    </div>
                                    <div id="faq-accordion-collapse-1" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-1" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <div class="flex flex-col lg:flex-row mt-2">
                                                <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                                    <span>
                                                        Next Payment
                                                    </span>
                                                </div>
                                                <div class="sm:whitespace-normal items-center text-right sm:w-1/2 sm:ml-auto">
                                                    <span class="font-medium">
                                                        23 Jun, 2021
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="flex flex-col lg:flex-row mt-2">
                                                <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                                    <span>
                                                        Payment Due Date
                                                    </span>
                                                </div>
                                                <div class="sm:whitespace-normal items-center text-right sm:w-1/2 sm:ml-auto">
                                                    <span class="font-medium">
                                                        25 Agust, 2021
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex flex-col lg:flex-row mt-2">
                                                <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                                    <span>
                                                        Bill
                                                    </span>
                                                </div>
                                                <div class="sm:whitespace-normal items-center text-right sm:w-1/2 sm:ml-auto">
                                                    <span class="font-medium">
                                                        1,25,846
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div id="faq-accordion-content-2" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-2" aria-expanded="false" aria-controls="faq-accordion-collapse-2"> BILLING INFORMATION</button>
                                    </div>
                                    <div id="faq-accordion-collapse-2" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-2" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <div class="flex flex-col lg:flex-row mt-2">
                                                <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                                    <span>
                                                        Company Name
                                                    </span>
                                                </div>
                                                <div class="sm:whitespace-normal items-center text-right sm:w-1/2 sm:ml-auto">
                                                        <span class="font-medium">
                                                        Kanexy
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex flex-col lg:flex-row mt-2">
                                                <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                                    <span>
                                                        Email Address
                                                    </span>
                                                </div>
                                                <div class="sm:whitespace-normal items-center text-right sm:w-1/2 sm:ml-auto">
                                                        <span class="font-medium">
                                                        kanexy@gmail.co
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex flex-col lg:flex-row mt-2">
                                                <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                                    <span>
                                                        VAT number
                                                    </span>
                                                </div>
                                                <div class="sm:whitespace-normal items-center text-right sm:w-1/2 sm:ml-auto">
                                                        <span class="font-medium">
                                                        RF845762158762
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div id="faq-accordion-content-3" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-3" aria-expanded="false" aria-controls="faq-accordion-collapse-3"> PAYMENT METHOD </button>
                                    </div>
                                    <div id="faq-accordion-collapse-3" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-3" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <div class="flex flex-col lg:flex-row mt-2">
                                                <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                                    <span>
                                                        Credit Card
                                                    </span>
                                                </div>
                                                <div class="sm:whitespace-normal items-center text-right sm:w-1/2 sm:ml-auto">
                                                        <span class="font-medium">
                                                        Ending in 5845
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex flex-col lg:flex-row mt-2">
                                                <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                                    <span>
                                                        Expiring
                                                    </span>
                                                </div>
                                                <div class="sm:whitespace-normal items-center text-right sm:w-1/2 sm:ml-auto">
                                                        <span class="font-medium">
                                                        09/28
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                            <div id="Overview" class="tab-pane active" role="tabpanel" aria-labelledby="Overview-tab">

                                <div class="intro-y col-span-12 lg:col-span-12 px-0">
                                    <div class="table-responsive  overflow-x-auto overflow-y-auto">
                                        <table class="table box px-0 table-report sm:mt-2">
                                            <thead>
                                                <tr class="bg-gray-400">
                                                    <th class="text-left whitespace-nowrap">Plan & Addon Details </th>
                                                    <th class="text-left whitespace-nowrap">Qty</th>
                                                    <th class="text-left whitespace-nowrap">Rate </th>
                                                    <th class="text-left whitespace-nowrap">Tax </th>
                                                    <th class="text-right whitespace-nowrap">Amount </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="intro-x zoom-in transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1">

                                                    <td class="px-4 py-2">Starter </td>
                                                    <td class="px-4 py-2 text-right">1</td>
                                                    <td class="px-4 py-2">1,000.00 </td>
                                                    <td class="px-4 py-2 text-center">-</td>
                                                    <td class="px-4 py-2 text-right bg-gray-400">$1,000.00</td>
                                                </tr>
                                                <tr class="intro-x zoom-in transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1">

                                                    <td class="px-4 py-2">Setup Free </td>
                                                    <td class="px-4 py-2 text-right">1</td>
                                                    <td class="px-4 py-2">1,000.00 </td>
                                                    <td class="px-4 py-2 text-center">-</td>
                                                    <td class="px-4 py-2 text-right bg-gray-400">$1,000.00</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="border px-1 sm:px-4 py-2 text-medium w-2/5"><strong>Total</strong></td>
                                                    <td class="border px-1 sm:px-4 py-2 text-right text-medium w-2/5"><strong>€0.00 GBP</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <p class="mt-4"><strong>NOTES</strong><br>
                                There are no notes added for this subscription.  <a class="text-gray-600" href="#"> Add Note</a></p>

                            </div>


                            <div id="InvoiceHistory" class="tab-pane" role="tabpanel" aria-labelledby="InvoiceHistory-tab">
                                <div class="box p-5 mt-5">
                                    <div class="flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                                        <div>
                                            <div class="text-gray-600">Time</div>
                                            <div class="mt-1">02/06/20 02:10 PM</div>
                                        </div>
                                        <i data-feather="clock" class="w-4 h-4 text-gray-600 ml-auto"></i>
                                    </div>
                                    <div class="flex items-center border-b border-gray-200 dark:border-dark-5 py-5">
                                        <div>
                                            <div class="text-gray-600">Customer</div>
                                            <div class="mt-1">Al Pacino</div>
                                        </div>
                                        <i data-feather="user" class="w-4 h-4 text-gray-600 ml-auto"></i>
                                    </div>
                                    <div class="flex items-center border-b border-gray-200 dark:border-dark-5 py-5">
                                        <div>
                                            <div class="text-gray-600">People</div>
                                            <div class="mt-1">3</div>
                                        </div>
                                        <i data-feather="users" class="w-4 h-4 text-gray-600 ml-auto"></i>
                                    </div>
                                    <div class="flex items-center pt-5">
                                        <div>
                                            <div class="text-gray-600">Table</div>
                                            <div class="mt-1">21</div>
                                        </div>
                                        <i data-feather="mic" class="w-4 h-4 text-gray-600 ml-auto"></i>
                                    </div>
                                </div>
                            </div>
                            <div id="RecentActivities" class="tab-pane" role="tabpanel" aria-labelledby="RecentActivities-tab">
                                <div class="box p-5 mt-5">
                                    <div class="flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                                        <div>
                                            <div class="text-gray-600">Time</div>
                                            <div class="mt-1">02/06/20 02:10 PM</div>
                                        </div>
                                        <i data-feather="clock" class="w-4 h-4 text-gray-600 ml-auto"></i>
                                    </div>
                                    <div class="flex items-center border-b border-gray-200 dark:border-dark-5 py-5">
                                        <div>
                                            <div class="text-gray-600">Customer</div>
                                            <div class="mt-1">Al Pacino</div>
                                        </div>
                                        <i data-feather="user" class="w-4 h-4 text-gray-600 ml-auto"></i>
                                    </div>
                                    <div class="flex items-center border-b border-gray-200 dark:border-dark-5 py-5">
                                        <div>
                                            <div class="text-gray-600">People</div>
                                            <div class="mt-1">3</div>
                                        </div>
                                        <i data-feather="users" class="w-4 h-4 text-gray-600 ml-auto"></i>
                                    </div>
                                    <div class="flex items-center pt-5">
                                        <div>
                                            <div class="text-gray-600">Table</div>
                                            <div class="mt-1">21</div>
                                        </div>
                                        <i data-feather="mic" class="w-4 h-4 text-gray-600 ml-auto"></i>
                                    </div>
                                </div>
                            </div>

                            <div id="Admin" class="tab-pane" role="tabpanel" aria-labelledby="Admin-tab">
                                <div class="box p-5 mt-5">
                                    This is Admin tab section data..!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div>
                    <div>
                        <div class="col-sm-12 text-right">
                        <button class="btn btn-sm btn-primary mr-0 my-2"> Download Invoice </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
