@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="flex items-center p-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Transactions Alert
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

                                            <div class="intro-y mt-0">
                                                <div
                                                    class="text-right flex-wrap sm:flex items-center justify-end sm:py-0 border-b border-gray-200 dark:border-dark-5">
                                                    <x-list-view-filters />
                                                    @if ($user->isSubscriber())
                                                        @can(\Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy::CREATE,
                                                        \Kanexy\InternationalTransfer\Contracts\MoneyTransfer::class)
                                                            <a href="{{ route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]) }}"
                                                                class="btn btn-sm btn-primary sm:ml-2 py-2 sm:mb-2 mb-2">Money
                                                                Transfer</a>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- BEGIN: HTML Table Data -->
                                            <div class="intro-y p-3 mt-0">
                                                <div class=" overflow-x-auto overflow-y-hidden">
                                                    <!-- <div id="tabulator" class="mt-5 table-report table-report--tabulator"></div> -->
                                                    <table id="tableID" class="shroting display table table-report -mt-2">
                                                        <thead
                                                            class="short-wrp dark:bg-darkmode-400 dark:border-darkmode-400">
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
                                                                                class="form-check-input" type="checkbox"
                                                                                value="">
                                                                            <label class="form-check-label"
                                                                                for="checkbox-switch-1"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="whitespace-nowrap text-left">
                                                                        <a class="active-clr" href="javascript:void(0);"
                                                                            onclick="Livewire.emit('showTransactionDetail', {{ $transaction->getKey() }});Livewire.emit('showTransactionLog', {{ $transaction->getKey() }});Livewire.emit('showTransactionAttachment', {{ $transaction->getKey() }});">{{ $transaction->urn }}</a>
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
                                                                        {{ \Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($transaction->amount, $transaction->meta['base_currency']) }}
                                                                    </td>
                                                                    <td class="whitespace-nowrap text-left">
                                                                        {{ $transaction->meta['second_beneficiary_name'] }}
                                                                    </td>

                                                                    <td class="whitespace-nowrap text-center">
                                                                        {{ $transaction->meta['exchange_currency'] }}
                                                                    </td>
                                                                    <td class="whitespace-nowrap text-right text-success">
                                                                        @isset($transaction->meta['recipient_amount'])
                                                                            {{ \Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($transaction->meta['recipient_amount'], $transaction->meta['exchange_currency']) }}
                                                                        @endisset
                                                                    </td>
                                                                    <td class="whitespace-nowrap text-left">
                                                                        {{ trans('international-transfer::configuration.' . $transaction->payment_method) }}
                                                                    </td>
                                                                    {{-- <td class="whitespace-nowrap text-right @if ($transaction->type === 'debit') text-theme-6 @else text-success @endif">
                                                                            {{ \Kanexy\PartnerFoundation\Core\Helper::getFormatAmount($transaction->amount) }}
                                                                        </td> --}}

                                                                    <td class="whitespace-nowrap text-left">
                                                                        {{ trans('international-transfer::configuration.' . $transaction->status) }}
                                                                    </td>

                                                                    <td class="whitespace-nowrap text-left"
                                                                        style="box-shadow: none;">
                                                                        <div class="dropdown">
                                                                            <button class="dropdown-toggle btn px-2 box"
                                                                                aria-expanded="false"
                                                                                data-tw-toggle="dropdown">
                                                                                <span
                                                                                    class="w-5 h-5 flex items-center justify-center">
                                                                                    <i data-lucide="settings"
                                                                                        class="w-5 h-5 text-gray-600"></i>
                                                                                </span>
                                                                            </button>
                                                                            <div class="dropdown-menu w-40">
                                                                                <ul class="dropdown-content">
                                                                                    @if (\Illuminate\Support\Facades\Auth::user()->isSuperadmin())
                                                                                        @if ($transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::CANCELLED)
                                                                                            @if ($transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED)
                                                                                                <li><a href="{{ route('dashboard.international-transfer.money-transfer.transferCompleted', $transaction->getKey()) }}"
                                                                                                        class="flex items-center block dropdown-item flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                                                        <x-feathericon-check-circle
                                                                                                            class="w-4 h-4 mr-1" />
                                                                                                        Completed
                                                                                                    </a></li>
                                                                                            @endif
                                                                                            @if ($transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::ACCEPTED &&
                                                                                                $transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED)
                                                                                                <li><a href="{{ route('dashboard.international-transfer.money-transfer.transferAccepted', $transaction->getKey()) }}"
                                                                                                        class="flex items-center block dropdown-item flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                                                        <x-feathericon-check
                                                                                                            class="w-4 h-4 mr-1" />
                                                                                                        Accepted
                                                                                                    </a></li>
                                                                                            @endif
                                                                                            @if ($transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::ACCEPTED &&
                                                                                                $transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::PENDING &&
                                                                                                $transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED)
                                                                                                <li><a href="{{ route('dashboard.international-transfer.money-transfer.transferPending', $transaction->getKey()) }}"
                                                                                                        class="flex items-center block dropdown-item flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                                                        <x-feathericon-alert-circle
                                                                                                            class="w-4 h-4 mr-1" />
                                                                                                        Pending
                                                                                                    </a></li>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif
                                                                                    <li><a href="javascript:void(0)"
                                                                                            onclick="Livewire.emit('showTransactionTrack', {{ $transaction->getKey() }});"
                                                                                            data-tw-toggle="modal"
                                                                                            data-tw-target="#superlarge-slide-over-size-preview"
                                                                                            class="flex items-center block dropdown-item flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                                            <x-feathericon-navigation-2
                                                                                                class="w-4 h-4 mr-1" />
                                                                                            Track
                                                                                        </a></li>
                                                                                    <li><a href="javascript:void(0)"
                                                                                            href="javascript:void(0);"
                                                                                            onclick="Livewire.emit('showTransactionDetail', {{ $transaction->getKey() }});Livewire.emit('showTransactionLog', {{ $transaction->getKey() }});Livewire.emit('showTransactionAttachment', {{ $transaction->getKey() }});"
                                                                                            class="flex items-center block dropdown-item flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                                            <x-feathericon-eye
                                                                                                class="w-4 h-4 mr-1" />
                                                                                            Show
                                                                                        </a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>
                                                <div class="my-2">
                                                    {{ $transactions->links() }}
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

    <div id="subscription-modal" class="modal modal-slide-over z-50" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header p-3">
                    <h2 class="text-lg font-medium mr-auto">Transfer Details</h2>

                    <a class="close intro-x cursor-pointer w-8 h-8 flex items-center justify-center rounded-full bg-theme-6 text-white ml-2 tooltip"
                        data-tw-dismiss="modal"> <i data-lucide="x" class="w-3 h-3"></i> </a>
                </div>


                <div class="modal-body pt-2">
                    <div class="pr-0 border-b border-gray-200 dark:border-dark-5">
                        <div class="p-0">
                            <ul class="nav nav-link-tabs text-center" role="tablist">
                                <li id="Overview-tab" class="nav-item flex-1" role="presentation">
                                    <a data-tw-toggle="pill" data-tw-target="#Overview" href="javascript:;"
                                        class="nav-link w-full py-2 active" role="tab" aria-controls="Overview"
                                        aria-selected="true">Overview</a>
                                </li>
                                <li id="Notes-tab" class="nav-item flex-1" role="presentation">
                                    <a data-tw-toggle="pill" data-tw-target="#Notes" href="javascript:;"
                                        class="nav-link w-full py-2" role="tab" aria-controls="Notes"
                                        aria-selected="false">Notes</a>
                                </li>
                                <li id="Attachments-tab" class="nav-item flex-1" role="presentation">
                                    <a data-tw-toggle="pill" data-tw-target="#Attachments" href="javascript:;"
                                        class="nav-link w-full py-2" role="tab" aria-controls="Attachments"
                                        aria-selected="false">Attachments</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content py-3">

                        <div id="Overview" class="tab-pane active " role="tabpanel" aria-labelledby="Overview-tab">
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

    <div id="superlarge-slide-over-size-preview" class="modal modal-slide-over" tabindex="-1" aria-hidden="true"
        style="padding-left: 0px;">
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
            const myModal = tailwind.Modal.getInstance(document.querySelector("#subscription-modal"));
            myModal.show();
        });
    </script>
@endpush
