@extends("international-transfer::configuration.skeleton")

@section('title', 'Transfer Reason')

@section('create-button')
    <a href="{{ route('dashboard.international-transfer.transfer-reason.create') }}" class="btn btn-sm btn-primary shadow-md">Create New</a>
@endsection

@section("config-content")
    <div class="p-5">
        <div class="overflow-x-auto box">
            <table class="table">
                <thead>
                    <tr class="bg-gray-300 dark:bg-dark-1">
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Reason</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Status</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1;
                @endphp
                @foreach ($money_transfer_reasons as $index => $money_transfer_reason)
                    <tr>
                        <td class="border-b dark:border-dark-5">{{ $index + 1 }}</td>
                        <td class="border-b dark:border-dark-5">{{ $money_transfer_reason['reason'] }}</td>
                        <td class="border-b dark:border-dark-5">{{ ucfirst($money_transfer_reason['status']) }}</td>

                        <td class="border-b dark:border-dark-5">
                            <div class="dropdown">
                                <button class="dropdown-toggle btn btn-sm" aria-expanded="false">
                                    <i data-feather="settings" class="w-5 h-5 text-gray-600"></i>
                                </button>

                                <div class="dropdown-menu w-48">
                                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                        <a href="{{ route('dashboard.international-transfer.transfer-reason.edit', $money_transfer_reason['id']) }}"
                                            class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                            <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                        </a>
                                        <form
                                            action="{{ route('dashboard.international-transfer.transfer-reason.destroy', $money_transfer_reason['id']) }}"
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
