@extends('cms::dashboard.layouts.default')

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
                        </div>
                        <div class="intro-y box col-span-12 lg:col-span-12">
                            <div class="p-5">
                                @foreach ($balances as $balance)
                                    <div class="relative flex items-center border-b pb-3">
                                        <div class="w-12 h-12 pt-1 flex-none image-fit">
                                            <img class="rounded-full" src="{{ $balance->meta['flag'] }}">
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <a href="" class="font-medium">{{ $balance->balance }} {{ $balance->currency }}</a>
                                            <div class="text-slate-500 mr-5 sm:mr-5">{{ $balance->currency }} ({{ $balance->meta['code'] }}) {{ $balance->meta['name'] }}</div>
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
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
