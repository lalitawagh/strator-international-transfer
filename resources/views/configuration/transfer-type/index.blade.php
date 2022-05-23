@extends("international-transfer::configuration.skeleton")

@section('title', 'Transfer Type Fee')

@section('create-button')
    <a href="{{ route('dashboard.international-transfer.transfer-type-fee.create') }}"
        class="btn btn-sm btn-primary shadow-md">Create New</a>
@endsection

@section('config-content')

    <div class="grid grid-cols-12 gap-3">
        @include('international-transfer::list-component')
        <div class="intro-y box p-3 mt-0 overflow-x-auto overflow-y-hidden">

                <table id="tableID" class="shroting display table table-report -mt-2">
                    <thead class="short-wrp">
                        <tr>
                            <th>
                                <div class="form-check mt-1 border-gray-400">
                                    <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                    <label class="form-check-label" for="checkbox-switch-1"></label>
                                </div>
                            </th>

                            <th class="whitespace-nowrap text-left">Currency
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
                                <span class="flex short-icon large-short-icon">
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
                                <span class="flex short-icon large-short-icon">
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
                                <span class="flex short-icon large-short-icon">
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
                                <span class="flex short-icon large-short-icon">
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
                            <th class="flex" style="width:40px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($transfer_type_fees as $index => $transfer_type_fee)
                            @php
                                $currency = \Kanexy\Cms\I18N\Models\Country::find($transfer_type_fee['currency']);
                            @endphp
                            <tr>
                                <td class="whitespace-nowrap text-left">{{ $transfer_type_fees->firstItem() + $i }}</td>
                                <td class="whitespace-nowrap text-left">{{ $currency->currency }}</td>
                                <td class="whitespace-nowrap text-left">{{ trans('international-transfer::configuration.'.$transfer_type_fee['type']) }}</td>
                                <td class="whitespace-nowrap text-right">{{ $transfer_type_fee['min_amount'] }}</td>
                                <td class="whitespace-nowrap text-right">{{ $transfer_type_fee['max_amount'] }}</td>
                                <td class="whitespace-nowrap text-right">{{ $transfer_type_fee['amount'] }}</td>
                                <td class="whitespace-nowrap text-right">{{ $transfer_type_fee['percentage'] }}</td>
                                <td class="whitespace-nowrap text-left">{{ ucfirst($transfer_type_fee['status']) }}</td>

                                <td class="whitespace-nowrap text-left">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle btn btn-sm" aria-expanded="false">
                                            <i data-feather="settings" class="w-5 h-5 text-gray-600"></i>
                                        </button>

                                        <div class="dropdown-menu w-48">
                                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                <a href="{{ route('dashboard.international-transfer.transfer-type-fee.edit', $transfer_type_fee['id']) }}"
                                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                    <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                                </a>
                                                <form
                                                    action="{{ route('dashboard.international-transfer.transfer-type-fee.destroy', $transfer_type_fee['id']) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="w-full flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-red-200 dark:hover:bg-dark-2 rounded-md">
                                                        <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>


        </div>
    </div>
    </div>
    </div>
    <div class="my-2">
        {{ $transfer_type_fees->links() }}
    </div>
    </div>
    </div>

@endsection