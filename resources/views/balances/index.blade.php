@extends('international-transfer::layouts.master')

@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div id="1" class="tab-pane grid grid-cols-12 gap-3 pt-0 active" role="tabpanel"
                    aria-labelledby="1-tab">
                    <div class="active col-span-12 mt-0 w-full" role="tabpanel" id="k-wallet" aria-labelledby="k-wallet-tab">
                        <div class="flex items-center px-3 py-2 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="text-lg font-medium truncate mr-auto">
                                Balances
                            </h2>
                            <a href="{{ route('dashboard.international-transfer.add-balance', ['filter' => ['workspace_id' => app('activeWorkspaceId')]])}}" class="btn btn-sm btn-primary shadow-md mr-0 mb-0">
                                Add Currency
                            </a>
                        </div>
                        <div class="intro-y box col-span-12 lg:col-span-12">
                            <div class="p-5">
                                @foreach ($currencyData as $country)
                                    <a href="{{ route('dashboard.international-transfer.currency-details', ['filter' => ['workspace_id' => app('activeWorkspaceId')], 'id' => $country['id']]) }}">
                                        <div class="relative flex items-center border-b pb-3">
                                            <div class="w-12 h-12 pt-1 flex-none image-fit">
                                                <img class="rounded-full" src="{{ $country->meta['flag'] }}">
                                            </div>
                                            <div class="ml-4 mr-auto">
                                                <div class="text-slate-500 mr-5 sm:mr-5">{{ $country->currency }} ({{ $country->meta['code'] }}) {{ $country->meta['name'] }}</div>
                                            </div>
                                            <div class="font-medium text-slate-600 dark:text-slate-500"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right"
                                                    class="lucide lucide-chevron-right w-6 h-6" data-lucide="chevron-right">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
