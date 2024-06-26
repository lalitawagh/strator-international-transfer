@extends('international-transfer::configuration.skeleton')

@section('title', 'Fee Setup')

@section('create-button')
    @can(\Kanexy\InternationalTransfer\Policies\FeePolicy::CREATE,
        \Kanexy\InternationalTransfer\Contracts\FeeConfiguration::class)
        <a href="{{ route('dashboard.international-transfer.fee.create') }}" class="btn btn-sm btn-primary shadow-md">Create
            New</a>
    @endcan
@endsection

@section('config-content')
    <div class="grid grid-cols-12 gap-3">
        @include('international-transfer::list-component')
        <div class="intro-y box p-3 mt-0">
            <div class="mt-0 overflow-x-auto overflow-y-hidden">
                <table id="tableID" class="shroting display table table-report -mt-2" style="width:100%">
                    <thead class="short-wrp dark:bg-darkmode-400 dark:border-darkmode-400">
                        <tr>
                            <th>
                                <div class="form-check mt-0 border-gray-400">
                                    <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                    <label class="form-check-label" for="checkbox-switch-1"></label>
                                </div>
                            </th>

                            <th class="whitespace-nowrap text-left">Type
                                <span class="flex short-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 up" fill="#c1c4c9"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 down" fill="#c1c4c9"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                    </svg>
                                </span>
                            </th>
                            <th class="whitespace-nowrap text-right">Min Amount
                                <span class="flex short-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 up" fill="#c1c4c9"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 down" fill="#c1c4c9"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                    </svg>
                                </span>
                            </th>
                            <th class="whitespace-nowrap text-right">Max Amount
                                <span class="flex short-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 up" fill="#c1c4c9"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 down" fill="#c1c4c9"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                    </svg>
                                </span>
                            </th>
                            <th class="whitespace-nowrap text-right">Amount
                                <span class="flex short-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 up" fill="#c1c4c9"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 down" fill="#c1c4c9"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                    </svg>
                                </span>
                            </th>
                            <th class="whitespace-nowrap text-right">Percentage
                                <span class="flex short-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 up" fill="#c1c4c9"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 down" fill="#c1c4c9"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                    </svg>
                                </span>
                            </th>
                            <th class="whitespace-nowrap text-left">Status</th>
                            @if (Gate::check(
                                    \Kanexy\InternationalTransfer\Policies\FeePolicy::EDIT,
                                    \Kanexy\InternationalTransfer\Contracts\FeeConfiguration::class) ||
                                    Gate::check(
                                        \Kanexy\InternationalTransfer\Policies\FeePolicy::DELETE,
                                        \Kanexy\InternationalTransfer\Contracts\FeeConfiguration::class))
                                <th class="flex" style="width:40px;">Action</th>
                            @endcan
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($fees as $index => $fee)
                        <tr>
                            <td class="whitespace-nowrap text-left">{{ $fees->firstItem() + $i }}</td>
                            <td class="whitespace-nowrap text-left">
                                {{ trans('international-transfer::configuration.' . $fee['type']) }}</td>
                            <td class="whitespace-nowrap text-right">{{ $fee['min_amount'] }}</td>
                            <td class="whitespace-nowrap text-right">{{ $fee['max_amount'] }}</td>
                            <td class="whitespace-nowrap text-right">{{ $fee['amount'] }}</td>
                            <td class="whitespace-nowrap text-right">{{ $fee['percentage'] }}</td>
                            <td class="whitespace-nowrap text-left">{{ ucfirst($fee['status']) }}</td>
                            @if (Gate::check(
                                    \Kanexy\InternationalTransfer\Policies\FeePolicy::EDIT,
                                    \Kanexy\InternationalTransfer\Contracts\FeeConfiguration::class) ||
                                    Gate::check(
                                        \Kanexy\InternationalTransfer\Policies\FeePolicy::DELETE,
                                        \Kanexy\InternationalTransfer\Contracts\FeeConfiguration::class))
                                <td class="whitespace-nowrap text-left">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle btn px-2 box" aria-expanded="false"
                                            data-tw-toggle="dropdown">
                                            <span class="w-5 h-5 flex items-center justify-center">
                                                <i data-lucide="settings" class="w-5 h-5 text-gray-600"></i>
                                            </span>
                                        </button>
                                        <div class="dropdown-menu w-40">
                                            <ul class="dropdown-content">
                                                @can(\Kanexy\InternationalTransfer\Policies\FeePolicy::EDIT,
                                                    \Kanexy\InternationalTransfer\Contracts\FeeConfiguration::class)
                                                    <li>
                                                        <a id="Edit"
                                                            href="{{ route('dashboard.international-transfer.fee.edit', $fee['id']) }}"
                                                            class="flex items-center block dropdown-item flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                            <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can(\Kanexy\InternationalTransfer\Policies\FeePolicy::DELETE,
                                                    \Kanexy\InternationalTransfer\Contracts\FeeConfiguration::class)
                                                    <li>
                                                        <button type="button" x-data={}
                                                            onclick="Livewire.emit('showModal','{{ route('dashboard.international-transfer.fee.destroy', $fee['id']) }}','DELETE', 'x-circle','Delete');"
                                                            class="w-full flex items-center block p-2 transition duration-300 ease-in-out dark:bg-dark-1 hover:bg-red-200 dark:hover:bg-dark-2 rounded-md">
                                                            <i data-lucide="trash" class="w-4 h-4 mr-2"></i>
                                                            Delete
                                                        </button>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="my-2">
            {{ $fees->links() }}
        </div>
    </div>
</div>
@endsection
