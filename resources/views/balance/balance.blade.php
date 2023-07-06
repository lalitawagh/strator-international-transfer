@extends('international-transfer::configuration.skeleton')

@section('title', 'Membership SubAccount Balance')
@section('config-content')
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
                                <div class="relative flex items-center border-b pb-3">
                                    <div class="w-12 h-12 flex-none image-fit">
                                        <img alt="Midone - HTML Admin Template" class="rounded-full"
                                            src="dist/images/profile-8.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <a href="" class="font-medium">99,659.19 USD</a>
                                        <div class="text-slate-500 mr-5 sm:mr-5">United States Dollar</div>
                                    </div>
                                    <div class="font-medium text-slate-600 dark:text-slate-500"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right"
                                            class="lucide lucide-chevron-right w-6 h-6" data-lucide="chevron-right">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg></div>
                                </div>
                                <div class="relative flex items-center border-b pb-3 mt-2">
                                    <div class="w-12 h-12 flex-none image-fit">
                                        <img alt="Midone - HTML Admin Template" class="rounded-full"
                                            src="dist/images/profile-2.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <a href="" class="font-medium">977,725.09 INR</a>
                                        <div class="text-slate-500 mr-5 sm:mr-5">Indian Rupee</div>
                                    </div>
                                    <div class="font-medium text-slate-600 dark:text-slate-500"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right"
                                            class="lucide lucide-chevron-right w-6 h-6" data-lucide="chevron-right">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg></div>
                                </div>
                                <div class="relative flex items-center border-b pb-3 mt-2">
                                    <div class="w-12 h-12 flex-none image-fit">
                                        <img alt="Midone - HTML Admin Template" class="rounded-full"
                                            src="dist/images/profile-9.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <a href="" class="font-medium">416,673.13 GBP</a>
                                        <div class="text-slate-500 mr-5 sm:mr-5">British Pound</div>
                                    </div>
                                    <div class="font-medium text-slate-600 dark:text-slate-500"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right"
                                            class="lucide lucide-chevron-right w-6 h-6" data-lucide="chevron-right">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
