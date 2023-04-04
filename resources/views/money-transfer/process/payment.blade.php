@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
    <div class="px-3 sm:px-5 mt-0 pt-5 border-t border-gray-200">
        <form method="POST" name="form"
            action="{{ route('dashboard.international-transfer.money-transfer.transactionDetail', ['filter' => ['workspace_id' => $workspace->id]]) }}">
            @csrf
            <div id="Transactions" class="grid grid-cols-12 gap-3" role="tabpanel" aria-labelledby="Transactions-tab">

                <div class="col-span-12 lg:col-span-8 xxl:col-span-8 mt-4">
                    <div class="grid grid-cols-12 gap-3">
                        <!-- BEGIN: -->
                        <div class="intro-y box col-span-12 xxl:col-span-12">
                            <div
                                class="flex items-center sm:px-5 sm:py-5 sm:py-3 mb-2 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="text-lg font-medium text-center pt-2">
                                    Choose Payment Option
                                </h2>
                            </div>
                            <div class="p-0">

                                <!-- BEGIN: Basic Accordion -->
                                <div class="col-span-12 lg:col-span-6">
                                    <div class="intro-y">
                                        <div id="basic-accordion" class="p-5">
                                            <div class="preview">
                                                <div id="faq-accordion-money-transfer" class="accordion">
                                                    @foreach (trans('international-transfer::payment') as $key => $payment)
                                                        <div class="accordion-item"
                                                            id="faq-accordion-cover-content-{{ $key }}">
                                                            <div id="faq-accordion-content-{{ $key }}"
                                                                class="accordion-header">
                                                                <button class="accordion-button" type="button"
                                                                    id="btn-faq-accordion-collapse-{{ $key }}"
                                                                    data-tw-toggle="collapse"
                                                                    data-tw-target="#faq-accordion-collapse-{{ $key }}"
                                                                    aria-expanded="true"
                                                                    aria-controls="faq-accordion-collapse-{{ $key }}">
                                                                    <div class="relative flex items-center pb-0"
                                                                        data-id="radio-switch-{{ $key }}">
                                                                        <div
                                                                            class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                                                                            <img alt="" class="rounded-full"
                                                                                style="padding:7px;"
                                                                                src="{{ $payment['image'] ?? '' }}">
                                                                        </div>
                                                                        <div class="ml-4 mr-auto"
                                                                            data-id="radio-switch-{{ $key }}">
                                                                            <a id="BankAccountSwich" class="font-medium"
                                                                                data-id="radio-switch-{{ $key }}">
                                                                                {{ $payment['title'] }}
                                                                                <br>
                                                                                @if (
                                                                                    $user->is_banking_user != 1 &&
                                                                                        $payment['method'] == 'bank_account' &&
                                                                                        is_null(\Kanexy\PartnerFoundation\Core\Facades\PartnerFoundation::getBankingPayment(request())))
                                                                                    <span
                                                                                        data-id="radio-switch-{{ $key }}"
                                                                                        class="paymentoption_error_message">For
                                                                                        the banking
                                                                                        payment method, you need to open a
                                                                                        bank account.</span><br>
                                                                                @endif
                                                                                @if (
                                                                                    $sender->code != 'UK' &&
                                                                                        $payment['method'] == 'bank_account' &&
                                                                                        is_null(\Kanexy\PartnerFoundation\Core\Facades\PartnerFoundation::getBankingPayment(request())))
                                                                                    <span
                                                                                        data-id="radio-switch-{{ $key }}"
                                                                                        class="paymentoption_error_message">The
                                                                                        Bank payment option are applicable
                                                                                        only, If the transfer is from
                                                                                        GBP</span><br>
                                                                                @endif
                                                                                @if ($sender->code != 'UK' && $payment['method'] == 'stripe')
                                                                                    <span style="color:red;">The Stripe
                                                                                        payment option are applicable only,
                                                                                        If the transfer is from
                                                                                        GBP</span><br>
                                                                                @endif
                                                                                @if ($sender->code != 'UK' && $payment['method'] == 'total_processing')
                                                                                    <span style="color:red;">The Total
                                                                                        payment option are applicable only,
                                                                                        If the transfer is from
                                                                                        GBP</span><br>
                                                                                    <span
                                                                                        data-id="radio-switch-{{ $key }}"
                                                                                        class="paymentoption_error_message">The
                                                                                        Stripe payment option are applicable
                                                                                        only, If the transfer is from
                                                                                        GBP</span><br>
                                                                                @endif
                                                                                @if (is_null($masterAccount) && $payment['method'] == 'manual_transfer')
                                                                                    <span
                                                                                        data-id="radio-switch-{{ $key }}"
                                                                                        class="paymentoption_error_message">The
                                                                                        Manual Transfer payment option is
                                                                                        not applicable for this
                                                                                        {{ $sender->code }} money
                                                                                        transfer.</span><br>
                                                                                @endif
                                                                            </a>
                                                                            {{-- <div
                                                                                class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                                                                <div class="mr-2">
                                                                                    {{ $payment['heading'] }}
                                                                                </div>

                                                                            </div> --}}
                                                                        </div>

                                                                        <div data-id="radio-switch-{{ $key }}"
                                                                            class="font-medium text-gray-700 dark:text-gray-500">
                                                                            <div class="form-check mt-2">
                                                                                <input
                                                                                    id="radio-switch-{{ $key }}"
                                                                                    class="form-check-input" type="radio"
                                                                                    name="payment_method"
                                                                                    value="{{ $payment['method'] }}"
                                                                                    @if ($user->is_banking_user != 1 && $payment['method'] == 'bank_account' && config('services.disable_banking') == true) hidden

                                                                                    @elseif (
                                                                                        $user->is_banking_user != 1 &&
                                                                                            $payment['method'] == 'bank_account' &&
                                                                                            is_null(\Kanexy\PartnerFoundation\Core\Facades\PartnerFoundation::getBankingPayment(request()))) disabled @elseif (
                                                                                        $sender->code != 'UK' &&
                                                                                            $payment['method'] == 'bank_account' &&
                                                                                            is_null(\Kanexy\PartnerFoundation\Core\Facades\PartnerFoundation::getBankingPayment(request()))) disabled @elseif ($sender->code != 'UK' && $payment['method'] == 'stripe') disabled @elseif ($sender->code != 'UK' && $payment['method'] == 'total_processing') disabled @elseif (is_null($masterAccount) && $payment['method'] == 'manual_transfer') disabled @endif>

                                                                                <label class="form-check-label"
                                                                                    for="radio-switch-{{ $key }}"></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                            <div id="faq-accordion-collapse-{{ $key }}"
                                                                data-id="radio-switch-{{ $key }}"
                                                                class="accordion-collapse collapse "
                                                                aria-labelledby="faq-accordion-content-{{ $key }}"
                                                                data-tw-parent="#faq-accordion-{{ $key }}">
                                                                <div data-id="radio-switch-{{ $key }}"
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
                <div
                    class="mt-4 bg-gray-400 dark:bg-darkmode-400 col-span-12 lg:col-span-4 xxl:col-span-4 flex lg:block flex-col-reverse">
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
                                        <div class="xl:flex flex">
                                            <div class="mr-auto">Sending Amount</div>
                                            <div class="font-medium">{{ $transferDetails['amount'] }}
                                                {{ $sender['currency'] }}</div>
                                        </div>

                                        <div class="xl:flex flex mt-4">
                                            <div class="mr-auto">Total Fees</div>
                                            <div class="font-medium">{{ $transferDetails['fee_charge'] }}
                                                {{ $sender['currency'] }}</div>
                                        </div>
                                        <div class="xl:flex flex mt-4">
                                            <div class="mr-auto">Amount we'll convert
                                            </div>
                                            <div class="font-medium">{{ $totalAmount }} {{ $sender['currency'] }}</div>
                                        </div>

                                        <div class="xl:flex flex mt-4">
                                            <div class="mr-auto">Exchange Rate </div>
                                            <div class="font-medium">{{ $transferDetails['guaranteed_rate'] }}</div>
                                        </div>
                                        <div class="xl:flex flex mt-4">
                                            <div class="mr-auto">Receiving Amount </div>
                                            <div class="font-medium">{{ $transferDetails['recipient_amount'] }}
                                                {{ $receiver['currency'] }}</div>
                                        </div>
                                        {{-- <div class="xl:flex flex mt-4">
                                            <div class="mr-auto">Should arrive </div>
                                            <div class="font-medium">By 19 may</div>
                                        </div> --}}
                                        <div class="col-span-12 md:col-span-6 mt-4 form-inline">
                                            <label for="bank_country" class="form-label sm:w-72"> Transfer Reason <span
                                                    class="text-theme-6">*</span></label>
                                            <div class="sm:w-1/5 lg:w-3/5 Transfer-reason ml-auto">
                                                <select name="transfer_reason" data-search="true" class="w-full">
                                                    @foreach ($reasons as $reason)
                                                        @if ($reason['status'] == \Kanexy\InternationalTransfer\Enums\Status::ACTIVE)
                                                            <option value="{{ $reason['id'] }}">{{ $reason['reason'] }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('transfer_reason')
                                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-12 md:col-span-6 mt-4 form-inline">
                                            <label for="delivery_method" class="form-label sm:w-72"> Delivery Method <span
                                                    class="text-theme-6">*</span></label>
                                            <div class="sm:w-1/5 lg:w-3/5 delivery-method ml-auto">
                                                <select name="delivery_method" data-search="true" class="w-full"
                                                    required>
                                                    @foreach (Kanexy\InternationalTransfer\Enums\DeliveryMethod::DELIVERY_METHOD as $index => $typeName)
                                                        <option wire:key="{{ $index }}"
                                                            value="{{ $index }}">
                                                            {{ $typeName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('delivery_method')
                                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if (
                                            @$riskInfo['transaction_risk_status'] == 'active' &&
                                                @$riskInfo['transaction_risk_source_of_fund'] == 'yes' &&
                                                @$riskInfo['transaction_risk_threshold'] <= $totalAmount)
                                            <div class="col-span-12 md:col-span-6 mt-4 form-inline">
                                                <label for="source_of_fund" class="form-label sm:w-72"> Source Of
                                                    Funds</label>
                                                <div class="sm:w-1/5 lg:w-3/5 source_of_fund ml-auto">
                                                    <select name="source_of_fund" data-search="true" class="w-auto"
                                                        required>
                                                        <option value="">Select Source Of Funds</option>
                                                        <option
                                                            value="Salaries, Operating Income, Return on Investment, Interests">
                                                            Salaries, Operating Income,Return on Investment, Interests
                                                        </option>
                                                        <option
                                                            value="Customers own funds, Investments, Property sale, Inheritances, Lottery.">
                                                            Customers own funds, Investments, Property sale, Inheritances,
                                                            Lottery.</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                    @error('source_of_fund')
                                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif

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
                <a id="PaymentPrevious"
                    href="{{ route('dashboard.international-transfer.money-transfer.beneficiary', ['filter' => ['workspace_id' => $workspace->id]]) }}"
                    class="btn btn-secondary w-24">Previous</a>
                <button id="PaymentSubmit" type="submit" class="btn btn-primary w-24 ml-2">Continue</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        let accordian = document.querySelector("#faq-accordion-money-transfer")
        document.getElementById("btn-faq-accordion-collapse-0").click()

        accordian.addEventListener('click', (e) => {
            let targetId = e.target.getAttribute('data-id') ?? e.target.id
            if (targetId) {
                if (!$('#' + targetId).prop("disabled")) {
                    $('#' + targetId).prop("checked", true);
                }

            }
        })
    </script>
@endpush
