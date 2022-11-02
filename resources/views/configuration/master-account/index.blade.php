@extends('international-transfer::configuration.skeleton')

@section('title', 'Money Transfer Collection Accounts')

@section('create-button')
    @can(\Kanexy\InternationalTransfer\Policies\MasterAccountPolicy::CREATE,
        \Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration::class)
        <a href="{{ route('dashboard.international-transfer.master-account.create') }}"
            class="btn btn-sm btn-primary shadow-md">Create New</a>
    @endcan
@endsection

@section('config-content')
    <div class="grid grid-cols-12 gap-3">
        @include('international-transfer::list-component')
        <div class="intro-y p-0 mt-0 overflow-x-auto overflow-y-hidden">
            <table id="tableID" class="shroting display table table-report -mt-2">
                <thead class="short-wrp dark:bg-darkmode-400 dark:border-darkmode-400">
                    <tr class="">
                        <th class="w-16 whitespace-nowrap text-left">#</th>
                        <th class="whitespace-nowrap text-left">Country
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
                        <th class="whitespace-nowrap text-left">Account Holder Name
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
                        <th class="whitespace-nowrap text-left">Account Number
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
                        <th class="whitespace-nowrap text-left">Sort Code / IFSC Code
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
                        <th class="whitespace-nowrap text-left">Account Branch
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
                        <th class="whitespace-nowrap text-left">Status
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
                        @if (Gate::check(
                            \Kanexy\InternationalTransfer\Policies\MasterAccountPolicy::EDIT,
                            \Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration::class) || Gate::check(\Kanexy\InternationalTransfer\Policies\MasterAccountPolicy::DELETE, \Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration::class))
                        <th class="whitespace-nowrap text-left">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($account_details as $index => $master_account)
                        <tr>
                            <td class="whitespace-nowrap text-left">{{ $index + 1 }}</td>
                            <td class="whitespace-nowrap text-left">
                                {{ \Kanexy\Cms\I18N\Models\Country::find($master_account['country'])?->name }}
                            </td>
                            <td class="whitespace-nowrap text-left">
                                {{ $master_account['account_holder_name'] }}
                            </td>
                            <td class="whitespace-nowrap text-left">{{ $master_account['account_number'] }}
                            </td>
                            <td class="whitespace-nowrap text-left">{{ @$master_account['sort_code'] }}
                                {{ @$master_account['ifsc_code'] }}
                            </td>
                            <td class="whitespace-nowrap text-left">{{ $master_account['account_branch'] }}
                            </td>
                            <td class="whitespace-nowrap text-left">
                                {{ trans('international-transfer::configuration.' . $master_account['status']) }}
                            </td>
                            @if (Gate::check(
                            \Kanexy\InternationalTransfer\Policies\MasterAccountPolicy::EDIT,
                            \Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration::class) || Gate::check(\Kanexy\InternationalTransfer\Policies\MasterAccountPolicy::DELETE, \Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration::class))
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
                                            @can(\Kanexy\InternationalTransfer\Policies\MasterAccountPolicy::EDIT,
                                            \Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration::class)
                                            <li>
                                                <a href="{{ route('dashboard.international-transfer.master-account.edit', $master_account['id']) }}"
                                                    class="flex items-center block dropdown-item flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                    <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                                </a>
                                            </li>
                                            @endcan

                                            @can(\Kanexy\InternationalTransfer\Policies\MasterAccountPolicy::DELETE,
                                            \Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration::class)
                                            <li>
                                                <form
                                                    action="{{ route('dashboard.international-transfer.master-account.destroy', $master_account['id']) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="w-full flex items-center block dropdown-item flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                        <i data-lucide="trash" class="w-4 h-4 mr-2"></i>
                                                        Delete
                                                    </button>
                                                </form>
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
            {{ $account_details->links() }}
        </div>
    </div>
@endsection
