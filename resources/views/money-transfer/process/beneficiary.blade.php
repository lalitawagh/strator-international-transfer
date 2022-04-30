@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
        <div class="intro-y col-span-12 lg:col-span-12">
            <h3 class="text-2xl font-black mb-4 text-center py-4">To whom would you like to beneficiary?</h3>
            <!-- BEGIN: Horizontal Form -->
            <div class="grid rounded-lg w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5">
                <div
                    class="font-medium text-base col-span-12 sm:col-span-12 xxl:col-span-12 py-3">
                    New Beneficiary</div>
                <a data-toggle="modal" data-target="#myself-modal"
                    class="border-2 border-theme-1 dark:border-theme-1 col-span-12 sm:col-span-4 xxl:col-span-3 p-5 cursor-pointer zoom-in text-center border-l border border-gray-200 dark:border-dark-5 rounded">
                    <div class="font-medium text-base"><i data-feather="box"
                            class="block w-12 h-12 mb-2 mx-auto"></i></div>
                    <div class="font-medium text-center text-base mt-3">Myself</div>
                </a>
                <a
                    class="col-span-12 sm:col-span-4 xxl:col-span-3 p-5 cursor-pointer zoom-in text-center border-l border border-gray-200 dark:border-dark-5 rounded">
                    <div class="font-medium text-base text-base"><i data-feather="inbox"
                            class="block w-12 h-12 mb-2 mx-auto"></i></div>
                    <div class="font-medium text-center text-base mt-3">Someone else</div>
                </a>
                <a
                    class="col-span-12 sm:col-span-4 xxl:col-span-3 p-5 cursor-pointer zoom-in text-center border-l border border-gray-200 dark:border-dark-5 rounded">
                    <div class="font-medium text-base"><i data-feather="activity"
                            class="block w-12 h-12 mb-2 mx-auto"></i></div>
                    <div class="font-medium text-center text-base mt-3">Business or charity
                    </div>
                </a>
            </div>

            <div
                class="grid rounded-lg w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5 mt-5 pt-3">
                <div
                    class="font-medium text-base col-span-12 sm:col-span-12 xxl:col-span-12 py-3">
                    Existing Beneficiary</div>
                <div class="intro-y col-span-12 lg:col-span-12">
                    <div class="relative flex items-center py-2 border-t border-gray-200">
                        <div
                            class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                            <i data-feather="home"
                                class="w-6 h-6 text-gray-700 dark:text-gray-300 mr-0"></i>
                        </div>
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Manully transfer the money
                                form your bank</a>
                            <div
                                class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                <div class="mr-2"> 0.79 CHF in total fess </div>
                                <div class="mr-2"> Manually transfer the money to
                                    Kanexy using your bank should arrive by may 19 </div>
                            </div>
                        </div>
                        <div class="font-medium text-gray-700 dark:text-gray-500">
                            <a href="javascript:;"
                                class="w-5 h-5 ml-5 flex items-center justify-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24px"
                                    height="24px" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right w-4 h-4 w-4 h-4">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg></a>
                        </div>
                    </div>

                    <div class="relative flex items-center py-2 border-t border-gray-200">
                        <div
                            class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                            <i data-feather="credit-card"
                                class="w-6 h-6 text-gray-700 dark:text-gray-300 mr-0"></i>
                        </div>
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Debit Card</a>
                            <div
                                class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                <div class="mr-2"> 1.01 CHF In total fess. should
                                    arrive in second</div>
                            </div>
                        </div>
                        <div class="font-medium text-gray-700 dark:text-gray-500">
                            <a href="javascript:;"
                                class="w-5 h-5 ml-5 flex items-center justify-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24px"
                                    height="24px" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right w-4 h-4 w-4 h-4">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg></a>
                        </div>
                    </div>

                    <div class="relative flex items-center py-2 border-t border-gray-200">
                        <div
                            class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                            <i data-feather="credit-card"
                                class="w-6 h-6 text-gray-700 dark:text-gray-300 mr-0"></i>
                        </div>
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Credit Card</a>
                            <div
                                class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                <div class="mr-2"> 1.01 CHF In total fess. should
                                    arrive in second </div>
                            </div>
                        </div>
                        <div class="font-medium text-gray-700 dark:text-gray-500">
                            <a href="javascript:;"
                                class="w-5 h-5 ml-5 flex items-center justify-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24px"
                                    height="24px" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right w-4 h-4 w-4 h-4">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg></a>
                        </div>
                    </div>
                </div>
                <div class="intro-y col-span-12 lg:col-span-12 m-auto">
                    <button class="btn btn-primary w-24 mb-10">Load More</button>
                </div>

            </div>


        </div>
        <div
            class="text-right mt-5 py-4  w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5 mt-5 pt-3 text-right mt-5  py-4">
            <button class="btn btn-secondary w-24">Previous</button>
            <button class="btn btn-primary w-24 ml-2" >Continue</button>
        </div>
    </div>

    <!-- BEGIN: Myself Modal -->
    <div id="myself-modal" class="modal modal-slide-over myself-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h2 class="font-medium text-base mr-auto">
                        Send to myself
                    </h2>
                    <div class="items-center justify-center mt-0">
                        {{-- <a data-toggle="modal" data-target="#review-transfer"
                            class="btn-sm bg-indigo-600 btn-primary text-white font-bold py-3 px-6 rounded">Confirm</a> --}}
                    </div>
                </div>
                <div class="modal-body">
                    @livewire('myself-beneficiary',['countries' => $countries, 'defaultCountry' => $defaultCountry, 'user' => $user, 'account' => $account, 'workspace' => $workspace])
                </div>
            </div>
        </div>
    </div>
    <!-- END: Myself Modal -->

    <!-- BEGIN: Myself Modal -->
    <div id="otp-modal" class="modal modal-slide-over otp-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h2 class="font-medium text-base mr-auto">
                        Otp Verification
                    </h2>
                    <div class="items-center justify-center mt-0">
                        {{-- <a data-toggle="modal" data-target="#review-transfer"
                            class="btn-sm bg-indigo-600 btn-primary text-white font-bold py-3 px-6 rounded">Confirm</a> --}}
                    </div>
                </div>
                <div class="modal-body">
                    @livewire('otp-verification',['countries' => $countries, 'defaultCountry' => $defaultCountry, 'user' => $user, 'account' => $account, 'workspace' => $workspace])
                </div>
            </div>
        </div>
    </div>
    <!-- END: Myself Modal -->
@endsection

@push('scripts')
    <script>
        window.addEventListener('showOtpModel', event => {
            $('.myself-modal').removeClass("show");
            $('.myself-modal').addClass("hide");
            $('#otp-modal').addClass('invisible');
            $('#otp-modal').attr('aria-hidden','false');
        });
    </script>
@endpush
