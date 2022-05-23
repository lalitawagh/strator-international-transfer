@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
    <div class="px-3 sm:px-5 mt-0 pt-5 border-t border-gray-200">
        <form method="POST" action="{{ route('dashboard.international-transfer.money-transfer.transactionDetail',['filter' => ['workspace_id' => $workspace->id]]) }}">
            @csrf
            <div id="Transactions" class="grid grid-cols-12 gap-3" role="tabpanel" aria-labelledby="Transactions-tab">

                <div class="col-span-12 lg:col-span-8 xxl:col-span-8 mt-4">
                    <div class="grid grid-cols-12 gap-3">
                        <!-- BEGIN: -->
                        <div class="intro-y box col-span-12 xxl:col-span-12">
                            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="text-lg font-medium text-center pt-2">
                                    Choose payment option
                                </h2>
                            </div>
                            <div class="p-0">

                                <!-- BEGIN: Basic Accordion -->
                                <div class="col-span-12 lg:col-span-6">
                                    <div class="intro-y">
                                        <div id="basic-accordion" class="p-5">
                                            <div class="preview">
                                                <div id="faq-accordion-1" class="accordion">
                                                    @foreach (trans('international-transfer::payment') as $key => $payment)
                                                        <div class="accordion-item">
                                                            <div id="faq-accordion-content-{{ $key }}" class="accordion-header">
                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-{{ $key }}" aria-expanded="true" aria-controls="faq-accordion-collapse-{{ $key }}">
                                                                    <div class="relative flex items-center pb-0">
                                                                        <div class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                                                                            <img alt="" class="rounded-full" style="padding:7px;" src="{{ $payment['image'] }}">
                                                                        </div>

                                                                        <div class="ml-4 mr-auto">
                                                                            <a href="" class="font-medium">{{ $payment['title'] }}</a>
                                                                            {{-- <div
                                                                                class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                                                                <div class="mr-2">
                                                                                    {{ $payment['heading'] }}
                                                                                </div>

                                                                            </div> --}}
                                                                        </div>
                                                                        <div class="font-medium text-gray-700 dark:text-gray-500">
                                                                            <div class="form-check mt-2">
                                                                                <input id="radio-switch-{{ $key }}" class="form-check-input" type="radio" name="payment_method" value="{{ $payment['method'] }}">
                                                                                <label class="form-check-label" for="radio-switch-{{ $key }}"></label>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                            <div id="faq-accordion-collapse-{{ $key }}"
                                                                class="accordion-collapse collapse @if ($key == 0) show @endif"
                                                                aria-labelledby="faq-accordion-content-{{ $key }}"
                                                                data-bs-parent="#faq-accordion-{{ $key }}">
                                                                <div
                                                                    class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                                                    {{ $payment['description'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @error('payment_method')
                                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                                    @enderror


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
                                            <div class="mr-auto">Sending Amount</div>
                                            <div class="font-medium">{{ $transferDetails['amount'] }} {{ $sender['currency'] }}</div>
                                        </div>

                                        <div class="flex mt-4">
                                            <div class="mr-auto">Total fees</div>
                                            <div class="font-medium">{{ $transferDetails['fee_charge'] }} {{ $sender['currency'] }}</div>
                                        </div>
                                        <div class="flex mt-4">
                                            <div class="mr-auto">Amount we'll convert
                                            </div>
                                            <div class="font-medium">{{ $totalAmount }} {{ $sender['currency'] }}</div>
                                        </div>

                                        <div class="flex mt-4">
                                            <div class="mr-auto">Exchange rate </div>
                                            <div class="font-medium">{{ $transferDetails['guaranteed_rate'] }}</div>
                                        </div>
                                        <div class="flex mt-4">
                                            <div class="mr-auto">Receiving Amount </div>
                                            <div class="font-medium">{{ $transferDetails['recipient_amount'] }} {{ $receiver['currency'] }}</div>
                                        </div>
                                        {{-- <div class="flex mt-4">
                                            <div class="mr-auto">Should arrive </div>
                                            <div class="font-medium">By 19 may</div>
                                        </div> --}}
                                        <div class="col-span-12 md:col-span-6 mt-4 form-inline">
                                            <label for="bank_country" class="form-label sm:w-48"> Transfer Reason <span class="text-theme-6">*</span></label>
                                            <div class="sm:w-5/6 Transfer-reason">
                                                <select name="transfer_reason" data-search="true" class="tail-select w-full">
                                                    @foreach ($reasons as $reason)
                                                        @if ($reason['status'] == \Kanexy\InternationalTransfer\Enums\Status::ACTIVE)
                                                            <option value="{{ $reason['id'] }}">{{ $reason['reason'] }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('transfer_reason')
                                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                                @enderror
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

            </div>
            <div class="text-right mt-5  py-4">
                <a href="{{ route('dashboard.international-transfer.money-transfer.beneficiary',['filter' => ['workspace_id' => $workspace->id]]) }}" class="btn btn-secondary w-24" >Previous</a>
                <button type="submit" class="btn btn-primary w-24 ml-2" >Continue</button>
            </div>
        </form>
    </div>
@endsection
