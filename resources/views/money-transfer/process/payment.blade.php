@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
    <div class="px-3 sm:px-5 mt-0 pt-5 border-t border-gray-200">



        <div class="col-span-12 lg:col-span-8 xxl:col-span-8 mt-4">
            <div class="grid grid-cols-12 gap-3">
                <!-- BEGIN: -->
                <div class="intro-y box col-span-12 xxl:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="text-2xl font-black text-center pt-2">
                            How would you like to pay?
                        </h2>
                    </div>
                    <div class="p-0">

                        <!-- BEGIN: Basic Accordion -->
                        <div class="col-span-12 lg:col-span-6">
                            <div class="intro-y">
                                <div id="basic-accordion" class="p-5">
                                    <div class="preview">
                                        <div id="faq-accordion-1" class="accordion">
                                            <div class="accordion-item">
                                                <div id="faq-accordion-content-1" class="accordion-header">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#faq-accordion-collapse-1" aria-expanded="true"
                                                        aria-controls="faq-accordion-collapse-1">
                                                        <div class="relative flex items-center pb-0">
                                                            <div
                                                                class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                                                                <img alt="" class="rounded-full" style="padding:7px;"
                                                                    src="{{ asset('dist/images/Yzer-Bank.png') }}">
                                                            </div>
                                                            <div class="ml-4 mr-auto">
                                                                <a href="" class="font-medium">Transfer
                                                                    from Yzer
                                                                    Bank Balance</a>
                                                                <div
                                                                    class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                                                    <div class="mr-2">
                                                                        0.79 CHF in
                                                                        total fess
                                                                    </div>
                                                                    <div class="mr-2">
                                                                        Manually
                                                                        transfer the
                                                                        money to Kanexy
                                                                        using your bank
                                                                        should arrive by
                                                                        may 19 </div>
                                                                </div>
                                                            </div>
                                                            <div class="font-medium text-gray-700 dark:text-gray-500">
                                                                <div class="form-check mt-2">
                                                                    <input id="radio-switch-1" class="form-check-input"
                                                                        type="radio" name="vertical_radio_button"
                                                                        value="vertical-radio-chris-evans">
                                                                    <label class="form-check-label"
                                                                        for="radio-switch-1"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                                <div id="faq-accordion-collapse-1" class="accordion-collapse collapse show"
                                                    aria-labelledby="faq-accordion-content-1"
                                                    data-bs-parent="#faq-accordion-1">
                                                    <div
                                                        class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                                        <p>Lorem ipsum is a placeholder text commonly used to demonstrate
                                                            the visual form of a document</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <div id="faq-accordion-content-2" class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-2"
                                                        aria-expanded="false" aria-controls="faq-accordion-collapse-2">
                                                        <div class="relative flex items-center pb-0">
                                                            <div
                                                                class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                                                                <img alt="" class="rounded-full" style="padding:7px;"
                                                                    src="{{ asset('dist/images/BankPay-Transfer.png') }}">
                                                            </div>
                                                            <div class="ml-4 mr-auto">
                                                                <a href="" class="font-medium">BankPay
                                                                    - Transfer
                                                                    From Other Bank</a>
                                                                <div
                                                                    class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                                                    <div class="mr-2">
                                                                        1.01 CHF In
                                                                        total
                                                                        fess. should
                                                                        arrive in second
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="font-medium text-gray-700 dark:text-gray-500">
                                                                <div class="form-check mt-2">
                                                                    <input id="radio-switch-2" class="form-check-input"
                                                                        type="radio" name="vertical_radio_button"
                                                                        value="vertical-radio-chris-evans">
                                                                    <label class="form-check-label"
                                                                        for="radio-switch-2"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                                <div id="faq-accordion-collapse-2" class="accordion-collapse collapse"
                                                    aria-labelledby="faq-accordion-content-2"
                                                    data-bs-parent="#faq-accordion-1">
                                                    <div
                                                        class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                                        <p>Lorem ipsum is a placeholder text commonly used to demonstrate
                                                            the visual form of a document</p>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <div id="faq-accordion-content-3" class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-3"
                                                        aria-expanded="false" aria-controls="faq-accordion-collapse-3">
                                                        <div class="relative flex items-center pb-0">
                                                            <div
                                                                class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                                                                <img alt="" class="rounded-full" style="padding:7px;"
                                                                    src="{{ asset('dist/images/CardPay-Debit.png') }}">
                                                            </div>
                                                            <div class="ml-4 mr-auto">
                                                                <a href="" class="font-medium">CardPay
                                                                    - Debit or
                                                                    Credit Cards</a>
                                                                <div
                                                                    class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                                                    <div class="mr-2">
                                                                        1.01 CHF In
                                                                        total
                                                                        fess. should
                                                                        arrive in second
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="font-medium text-gray-700 dark:text-gray-500">
                                                                <div class="form-check mt-2">
                                                                    <input id="radio-switch-2" class="form-check-input"
                                                                        type="radio" name="vertical_radio_button"
                                                                        value="vertical-radio-chris-evans">
                                                                    <label class="form-check-label"
                                                                        for="radio-switch-2"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                                <div id="faq-accordion-collapse-3" class="accordion-collapse collapse"
                                                    aria-labelledby="faq-accordion-content-3"
                                                    data-bs-parent="#faq-accordion-1">
                                                    <div
                                                        class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                                        <p>Lorem ipsum is a placeholder text commonly used to demonstrate
                                                            the visual form of a document</p>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <div id="faq-accordion-content-4" class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4"
                                                        aria-expanded="false" aria-controls="faq-accordion-collapse-4">
                                                        <div class="relative flex items-center pb-0">
                                                            <div
                                                                class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                                                                <img alt="" class="rounded-full" style="padding:7px;"
                                                                    src="{{ asset('dist/images/Manually-Transfer.png') }}">
                                                            </div>
                                                            <div class="ml-4 mr-auto">
                                                                <a href="" class="font-medium">Manually
                                                                    Transfer</a>
                                                                <div
                                                                    class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                                                    <div class="mr-2">
                                                                        1.01 CHF In
                                                                        total
                                                                        fess. should
                                                                        arrive in second
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="font-medium text-gray-700 dark:text-gray-500">
                                                                <div class="form-check mt-2">
                                                                    <input id="radio-switch-2" class="form-check-input"
                                                                        type="radio" name="vertical_radio_button"
                                                                        value="vertical-radio-chris-evans">
                                                                    <label class="form-check-label"
                                                                        for="radio-switch-2"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                                <div id="faq-accordion-collapse-4" class="accordion-collapse collapse"
                                                    aria-labelledby="faq-accordion-content-4"
                                                    data-bs-parent="#faq-accordion-1">
                                                    <div
                                                        class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                                        <p>Lorem ipsum is a placeholder text commonly used to demonstrate
                                                            the visual form of a document</p>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <div id="faq-accordion-content-5" class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-5"
                                                        aria-expanded="false" aria-controls="faq-accordion-collapse-4">
                                                        <div class="relative flex items-center pb-0">
                                                            <div
                                                                class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                                                                <img alt="" class="rounded-full" style="padding:7px;"
                                                                    src="{{ asset('dist/images/WalletPay.png') }}">
                                                            </div>
                                                            <div class="ml-4 mr-auto">
                                                                <a href="" class="font-medium">WalletPay</a>
                                                                <div
                                                                    class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                                                    <div class="mr-2">
                                                                        1.01 CHF In
                                                                        total
                                                                        fess. should
                                                                        arrive in second
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="font-medium text-gray-700 dark:text-gray-500">
                                                                <div class="form-check mt-2">
                                                                    <input id="radio-switch-2" class="form-check-input"
                                                                        type="radio" name="vertical_radio_button"
                                                                        value="vertical-radio-chris-evans">
                                                                    <label class="form-check-label"
                                                                        for="radio-switch-2"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                                <div id="faq-accordion-collapse-5" class="accordion-collapse collapse"
                                                    aria-labelledby="faq-accordion-content-5"
                                                    data-bs-parent="#faq-accordion-1">
                                                    <div
                                                        class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                                        <p>Lorem ipsum is a placeholder text commonly used to demonstrate
                                                            the visual form of a document</p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Basic Accordion -->
                    </div>
                </div>

                <!-- END: Daily Sales -->
            </div>
            <!-- Begin: Pay card code -->
            <div class="grid grid-cols-12 gap-3 mt-3">
                <div class="intro-y box col-span-12 xxl:col-span-12">
                    <div
                        class="w-full flex-column items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="text-3xl font-black pt-2 w-full flex-column">Pay with your card</h2>
                        {{-- <h4
                            class="w-full flex-column font-medium text-gray-700 dark:text-gray-500 pt-2">
                            <a href="javascript:void(0);">Pay another way</a>
                        </h4> --}}
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-12 form-inline mt-2">
                                <label for="" class="form-label sm:w-30">Card Number
                                </label>
                                <input id="" type="numbert" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <div class="form form-inline">
                                    <label for="bank_name" class="form-label sm:w-30">Expiry date (MM/YY)</label>
                                    <input id="bank_name" name="bank_name" type="text"
                                        class="form-control w-full @if ($errors->has('bank_name')) border-theme-6 @endif"
                                        placeholder="">
                                    <span class="text-theme-6 block mt-2"></span>
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <div class="form form-inline">
                                    <label for="bank_account_number" class="form-label sm:w-20">CVV/CVC</label>
                                    <input id="bank_account_number" name="bank_account_number" type="text"
                                        class="form-control w-full @if ($errors->has('bank_account_number')) border-theme-6 @endif"
                                        placeholder="">
                                    <span class="text-theme-6 block mt-2"></span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-12 form-inline mt-2">
                                <label for="bank_account_number" class="form-label sm:w-30"></label>
                                <div class="form-check mt-0">
                                    <input id="vertical-form-3" class="form-check-input" type="checkbox" value="">
                                    <label class="form-check-label" for="vertical-form-3">Save card for future
                                        paymentd</label>
                                </div>
                            </div>
                        </div>
                        {{-- <form>
                            <div>
                                <label for="" class="form-label">Card Number
                                </label>
                                <input id="" type="numbert" class="form-control" placeholder="">
                            </div>
                            <div class="md:flex mt-2 gap-2">
                                <div class="lg:w-1/2 mb-2 px-0">
                                    <div class="form">
                                        <label for="bank_name"
                                            class="form-label">Expiry date
                                            (MM/YY)</label>
                                        <input id="bank_name" name="bank_name"
                                            type="text"
                                            class="form-control w-full @if ($errors->has('bank_name')) border-theme-6 @endif"
                                            placeholder="">
                                        <span class="text-theme-6 block mt-2"></span>
                                    </div>
                                </div>
                                <div class="lg:w-1/2 mb-2 pl-0 pr-0">
                                    <div class="form">
                                        <label for="bank_account_number"
                                            class="form-label">CVV/CVC</label>
                                        <input id="bank_account_number"
                                            name="bank_account_number" type="text"
                                            class="form-control w-full @if ($errors->has('bank_account_number')) border-theme-6 @endif"
                                            placeholder="">
                                        <span class="text-theme-6 block mt-2"></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="form-check mt-0 form-control">
                                    <input id="vertical-form-3"
                                        class="form-check-input" type="checkbox"
                                        value="">
                                    <label class="form-check-label"
                                        for="vertical-form-3">Save card for future
                                        paymentd</label>
                                </div>
                            </div>

                        </form> --}}
                        <div>
                            {{-- <button class="btn btn-primary w-full mt-4 py-3 font-medium" @click="step++">Pay 1000 GBP</button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Pay card code -->
        </div>
        <!-- BEGIN: Profile Menu -->
        <div class="mt-4 bg-gray-400 col-span-12 lg:col-span-4 xxl:col-span-4 flex lg:block flex-col-reverse">
            <div class="intro-y bg-transparent mt-5 lg:mt-0 p-3">
                <!-- BEGIN: Ticket -->
                <div class="col-span-12 lg:col-span-4">

                    <div class="tab-content">
                        <div id="TransactionDetails" class="" role="tabpanel"
                            aria-labelledby="TransactionDetails-tab">
                            <div class="box p-5 mt-1">
                                <div class="flex">
                                    <div class="col-span-12 pb-4 text-center">
                                        <h3><strong>Transfer details</strong></h3>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="mr-auto">Sender</div>
                                    <div class="font-medium">1,000 GBP</div>
                                </div>
                                <div class="flex mt-4">
                                    <div class="mr-auto">Discount applied</div>
                                    <div class="font-medium">3.89 GBP</div>
                                </div>
                                <div class="flex mt-4">
                                    <div class="mr-auto">Total fees</div>
                                    <div class="font-medium">0.67 GBO</div>
                                </div>
                                <div class="flex mt-4">
                                    <div class="mr-auto">Amount we'll convert
                                    </div>
                                    <div class="font-medium">999.54 GBP</div>
                                </div>

                                <div class="flex mt-4">
                                    <div class="mr-auto">Guaranteed rate (2
                                        hours) </div>
                                    <div class="font-medium">1.0232</div>
                                </div>
                                <div class="flex mt-4">
                                    <div class="mr-auto">Receiver </div>
                                    <div class="font-medium">103000 INR</div>
                                </div>
                                <div class="flex mt-4">
                                    <div class="mr-auto">Should arrive </div>
                                    <div class="font-medium">By 19 may</div>
                                </div>
                                <div class="col-span-12 md:col-span-6 mt-4 form-inline">
                                    <label for="bank_country" class="form-label sm:w-40"> Transfer Reason </label>
                                    <div class="sm:w-5/6">
                                        <select name="" data-search="true" class="tail-select w-full "
                                            data-select-hidden="display" data-tail-select="tail-1">
                                            <option disabled=""></option>
                                            <option value="1" selected="selected">Friends</option>
                                            <option value="2">Family</option>
                                            <option value="3">Business</option>
                                            <option value="4">Other</option>
                                        </select>

                                    </div>
                                </div>

                            </div>
                            <div class="flex mt-5">
                            </div>
                        </div>

                    </div>
                </div>


                {{-- <button class="btn btn-primary w-full mb-2">Continue to payment</button> --}}

                {{-- <a href="javascript:void(0);" class="btn-link text-center block">Looking for a different way to pay?</a> --}}

                <!-- END: Ticket -->

            </div>

        </div>
        <!-- END: Profile Menu -->


        <div class="text-right mt-5  py-4">
            <button class="btn btn-secondary w-24" @click="step--">Previous</button>
            <button class="btn btn-primary w-24 ml-2" @click="step++">Continue</button>
        </div>

    </div>
@endsection
