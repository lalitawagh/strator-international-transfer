@extends("international-transfer::configuration.skeleton")

@section('title', 'Transfer Type Fee')

@section('create-button')
    <a href="{{ route('dashboard.international-transfer.transfer-type-fee.create') }}" class="btn btn-sm btn-primary shadow-md">Create New</a>
@endsection

@section("config-content")
    <div class="p-5">
        <div class="overflow-x-auto box">
            <table class="table">
                <thead>
                    <tr class="bg-gray-300 dark:bg-dark-1">
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Type</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Min Amount</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Max Amount</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Amount</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Percentage</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Statue</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1;
                @endphp
                @foreach ($transfer_type_fees as $index => $transfer_type_fee)
                    <tr>
                        <td class="border-b dark:border-dark-5">{{ $index + 1 }}</td>
                        <td class="border-b dark:border-dark-5">{{ $transfer_type_fee['type'] }}</td>
                        <td class="border-b dark:border-dark-5">{{ $transfer_type_fee['min_amount'] }}</td>
                        <td class="border-b dark:border-dark-5">{{ $transfer_type_fee['max_amount'] }}</td>
                        <td class="border-b dark:border-dark-5">{{ $transfer_type_fee['amount'] }}</td>
                        <td class="border-b dark:border-dark-5">{{ $transfer_type_fee['percentage'] }}</td>
                        <td class="border-b dark:border-dark-5">{{ ucfirst($transfer_type_fee['status']) }}</td>

                        <td class="border-b dark:border-dark-5">
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
        <div class="my-2">

        </div>
    </div>

@endsection
