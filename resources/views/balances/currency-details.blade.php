@extends('international-transfer::layouts.master')

@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="bg-gray">
                <div id="1" class="tab-pane grid grid-cols-12 gap-3 pt-0 active" role="tabpanel"
                    aria-labelledby="1-tab">
                    <div class="active col-span-12 mt-0 w-full" role="tabpanel" id="k-wallet" aria-labelledby="k-wallet-tab">
                        <div class="py-4 flex items-center px-3 py-2 border-b border-gray-200 dark:border-dark-5">
                            <ol class="breadcrumb text-lg font-medium mr-auto">
                                <li class="breadcrumb-item"><a href="#">Balances</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $currencyDetails->currency }}</li>
                            </ol>
                        </div>
                        <div class="intro-y col-span-12 lg:col-span-12 py-5">
                            <div class="p-5">
                                <div class="relative flex items-center mr-auto pb-3">
                                    <div class="w-12 h-12 flex-none image-fit">
                                        <img class="rounded-full" src="{{ $currencyDetails->meta['flag'] }}">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <a href="" class="text-2xl">99,659.19 {{ $currencyDetails->currency }}</a>
                                        <div class="text-slate-500 mr-5 sm:mr-5">{{ $currencyDetails->meta['name'] }}</div>
                                    </div>
                                    <div class="flex items-center ml-auto gap-10 justify-content">
                                        <a href="javascript:void(0);">
                                            <div class="mx-auto text-center">
                                                <div class="flex-none bg-dark rounded-full mx-auto">
                                                    <i data-lucide="plus-circle"
                                                        class="notification__icon dark:text-slate-500 m-auto"></i>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="font-medium">Pay {{ $currencyDetails->currency }}</div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0);">
                                            <div class="mx-auto text-center">
                                                <div class="flex-none bg-dark rounded-full mx-auto">
                                                    <i data-lucide="refresh-ccw"
                                                        class="notification__icon dark:text-slate-500 m-auto"></i>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="font-medium">Convert {{ $currencyDetails->currency }}</div>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-12 py-20">
                                    <ol class="breadcrumb text-lg font-medium mr-auto pb-4">
                                        <li class="breadcrumb-item"><a href="#">My {{ $currencyDetails->currency }} Account Details</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"></li>
                                    </ol>
                                    <div class="ml-0 mr-auto">
                                        <div class="text-lg font-medium truncate text-2xl">Activity</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
