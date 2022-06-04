@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
    <div class="px-3 sm:px-5 lg:px-10 xl:px-20 mt-5 pt-5 border-t border-gray-200">

        <form method="GET"
            action="{{ route('dashboard.international-transfer.money-transfer.final', ['filter' => ['workspace_id' => $workspace->id]]) }}">

            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Horizontal Form -->
                <div class="intro-y mt-0 clearfix">
                    <div class="border-2 border-dashed border-gray-200 dark:border-dark-5 rounded-md sm:p-5 sm:m-3">
                        @if ($transferDetails['payment_method'] == \Kanexy\InternationalTransfer\Enums\PaymentMethod::MANUAL_TRANSFER)
                            <div class=" p-3 bg-gray-200 sm:flex text-lg text-theme-1 dark:text-theme-10 font-medium mb-3">
                                <h3 class="text-lg font-medium mr-auto mb-0">Bank Transfer Details</h3>
                                <div class="text-xs text-right sm:ml-auto flex mb-0">
                                    <a target="_blank" href="https://mail.google.com/mail/u/0/?fs=1&tf=cm&subject=Manual transfer Account Details&body= Beneficiary :- {{ $beneficiary->display_name }} %0D%0A Payment reference :- {{ @$transferDetails['transaction']->meta['reference_no'] }} %0D%0A Amount To Send:- {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }}
                                            %0D%0A Bank Account Name:- {{ $masterAccount['account_holder_name'] }} %0D%0A Account Number :- {{ $masterAccount['account_number'] }} %0D%0A Sort Code :- {{ $masterAccount['sort_code'] }}  ">
                                        <i data-feather="share-2" class="dark:text-gray-300 block mx-auto mr-2"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="get_pdf('manual')"><i data-feather="download" class="dark:text-gray-300 block mx-auto mr-2"></i></a>
                                    <a onclick="copyData(this)"
                                        data-copy="Manual transfer Account Details- Beneficiary :- {{ $beneficiary->display_name }}  Payment reference :- {{ @$transferDetails['transaction']->meta['reference_no'] }}  Amount To Send:- {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }}
                                            Bank Account Name:- {{ $masterAccount['account_holder_name'] }}  Account Number :- {{ $masterAccount['account_number'] }}  Sort Code :- {{ $masterAccount['sort_code'] }}  "
                                        href="javascript:void(0);">
                                        <i data-feather="copy" class="dark:text-gray-300 block mx-auto mr-2"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="px-5 sm:px-0 flex flex-col-reverse sm:flex-row grid grid-cols-12 gap-2">
                                <div
                                    class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                    <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Payee Name</div>
                                    <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                        {{ $beneficiary->display_name }}</div>
                                </div>
                                <div
                                    class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                    <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Payment Reference </div>
                                    <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                        {{ @$transferDetails['transaction']->meta['reference_no'] }}</div>
                                </div>
                                <div
                                    class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                    <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Amount to Send </div>
                                    <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                        {{ $transferDetails['transaction']->amount }}
                                        {{ $transferDetails['transaction']->settled_currency }}</div>
                                </div>
                            </div>

                            <div class="p-3 bg-gray-200 sm:flex text-lg text-theme-1 dark:text-theme-10 font-medium mt-3">
                                <h3 class="text-lg font-medium mr-auto mb-0">Bank Account Details For Manual Transfer</h3>
                            </div>
                            <div class="px-5 mt-5 sm:px-0 flex flex-col-reverse sm:flex-row grid grid-cols-12 gap-2">
                                <div
                                    class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                    <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Bank Account Name </div>
                                    <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                        {{ $masterAccount['account_holder_name'] }}</div>
                                </div>
                                <div
                                    class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                    <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Bank Account Number </div>
                                    <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                        {{ $masterAccount['account_number'] }}</div>
                                </div>
                                <div
                                    class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                    <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Bank Account Sort Code </div>
                                    <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                        {{ $masterAccount['sort_code'] }}</div>
                                </div>
                            </div>
                        @else
                            @if ($transferDetails['payment_method'] == 'bank_account')
                                @php
                                    $payment = 'Bank';
                                @endphp
                            @else
                                @php
                                    $payment = 'Stripe';
                                @endphp
                            @endif
                            <div class="p-3 bg-gray-200 sm:flex text-lg text-theme-1 dark:text-theme-10 font-medium mt-0">
                                <h3 class="text-lg font-medium mr-auto mb-0">
                                    {{ $payment }} Transfer Details
                                </h3>
                                <div class="text-xs text-right sm:ml-auto flex mb-0">
                                    <a target="_blank" href="https://mail.google.com/mail/u/0/?fs=1&tf=cm&subject={{ $payment }} transfer Account Details&body= Recipient Name :- {{ $secondBeneficiary?->meta['bank_account_name'] }} %0D%0A Recipient Account Number :- {{ $secondBeneficiary?->meta['bank_account_number'] }} %0D%0A @isset($secondBeneficiary?->meta['bank_code']) Recipient Sort Number:- {{ @$secondBeneficiary?->meta['bank_code'] }} @endisset @isset($secondBeneficiary?->meta['iban_number']) Recipient IFSC Code / IBAN:- {{ @$secondBeneficiary?->meta['iban_number'] }} @endisset
                                            %0D%0A Amount To Send:- {{ $transferDetails['amount'] }} {{ $sender->currency }} %0D%0A Payment Method :- {{ $transferDetails['payment_method'] }} %0D%0A Transfer Reason :- {{ @$transferReason['reason'] }}  ">
                                        <i data-feather="share-2" class="dark:text-gray-300 block mx-auto mr-2"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="get_pdf('{{ $payment }}')"><i data-feather="download" class="dark:text-gray-300 block mx-auto mr-2"></i></a>
                                    <a onclick="copyData(this)"
                                        data-copy="{{ $payment }} transfer Account Details- Recipient Name :- {{ $secondBeneficiary?->meta['bank_account_name'] }}  Recipient Account Number :- {{ $secondBeneficiary?->meta['bank_account_number'] }}  @isset($secondBeneficiary?->meta['bank_code']) Recipient Sort Number:- {{ @$secondBeneficiary?->meta['bank_code'] }} @endisset @isset($secondBeneficiary?->meta['iban_number'])Recipient IFSC Code / IBAN:- {{ @$secondBeneficiary?->meta['iban_number'] }} @endisset Amount To Send:- {{ $transferDetails['amount'] }} {{ $sender->currency }}  Payment Method :- {{ $transferDetails['payment_method'] }}  Transfer Reason :- {{ @$transferReason['reason'] }} "
                                        href="javascript:void(0);">
                                        <i data-feather="copy" class="dark:text-gray-300 block mx-auto mr-2"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="grid grid-cols-12">
                                <div class="col-span-12 sm:col-span-12 md:col-span-12 xl:col-span-12">
                                    <div class="border-b border-gray-200 dark:border-dark-5 px-2 pb-4 mt-3 sm:px-2 flex flex-col-reverse sm:flex-row grid grid-cols-12 gap-2">
                                        <div
                                            class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                            <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Recipient Name</div>
                                            <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                                {{ $secondBeneficiary?->meta['bank_account_name'] }}</div>
                                        </div>
                                        <div
                                            class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                            <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Recipient Account Number </div>
                                            <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                                {{ $secondBeneficiary?->meta['bank_account_number'] }}</div>
                                        </div>
                                        @isset($secondBeneficiary?->meta['bank_code'])
                                        <div
                                            class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                            <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Recipient Sort Number </div>
                                            <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                                {{ @$secondBeneficiary?->meta['bank_code'] }}</div>
                                        </div>
                                        @endisset
                                        @isset($secondBeneficiary?->meta['iban_number'])
                                        <div
                                            class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                            <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Recipient IFSC Code / IBAN </div>
                                            <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                                {{ @$secondBeneficiary?->meta['iban_number'] }}</div>
                                        </div>
                                        @endisset
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-12 md:col-span-12 xl:col-span-12">
                                    <div class="border-b border-gray-200 dark:border-dark-5 px-2 pb-4 mt-3 sm:px-2 flex flex-col-reverse sm:flex-row grid grid-cols-12 gap-2">
                                        <div
                                            class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                            <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Amount To Send </div>
                                            <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                                {{ $transferDetails['amount'] }} {{ $sender->currency }}</div>
                                        </div>
                                        <div
                                            class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                            <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Payment Method </div>
                                            <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                                {{ ucfirst($transferDetails['payment_method']) }}</div>
                                        </div>
                                        <div
                                            class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-6 xl:col-span-6 sm:flex sm:px-4">
                                            <div class="font-medium sm:w-3/4 text-base text-gray-600 mr-2 mr-auto">Transfer Reason </div>
                                            <div class="text-base text-theme-1 dark:text-theme-10 font-medium mt-0 sm:w-1/3 text-sm">
                                                {{ @$transferReason['reason'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-right mt-3 py-4">
                @isset($transferDetails['transaction'])
                <a href="{{ route('dashboard.international-transfer.money-transfer.cancelTransfer', $transferDetails['transaction']->id) }}"
                    class="btn btn-secondary text-center mr-1 mb-2 ml-auto">Cancel this transfer</a>
                @endisset
                <button type="submit" class="btn btn-primary w-24">Continue</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>

    <script>
        function get_pdf(type) {
            var doc = new jsPDF();
            var specialElementHandlers = {
                '#editor': function(element, renderer) {
                    return true;
                }
            };
            if (type == 'manual') {
                doc.fromHTML(
                    '<h2>Manually Transfer Account Details</h2><div><div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2"> Beneficiary :- {{ $beneficiary?->display_name }} </br></div><div class="mt-1">Payment reference :- @isset($transferDetails['transaction']) {{ @$transferDetails['transaction']->meta['reference_no'] }} @endisset</br></div><div class="mt-1">Amount to send :- @isset($transferDetails['transaction']) {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }} @endisset </br></div><div class="mt-1">Bank Account Name :- {{ $masterAccount['account_holder_name'] }} </br></div><div class="mt-1">Bank Account Number :- {{ $masterAccount['account_number'] }} </br></div><div class="mt-1">Bank Sort Code :- {{ $masterAccount['sort_code'] }} </br></div></div>',
                    15, 15, {
                        'width': 170,
                        'elementHandlers': specialElementHandlers
                    });
                doc.save('manual-transfer-bank-detail.pdf');
            } else {
                doc.fromHTML(
                    '<h2>'+type+' Transfer Account Details</h2><div><div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2"> Recipient Name :- {{ $secondBeneficiary?->meta['bank_account_name'] }} </br></div><div class="mt-1">Recipient Account Number :- {{ $secondBeneficiary?->meta['bank_account_number'] }} </br></div><div class="mt-1"> @isset($secondBeneficiary?->meta['bank_code']) Recipient Sort Number :- {{ @$secondBeneficiary?->meta['bank_code'] }} @endisset @isset($secondBeneficiary?->meta['iban_number']) Recipient IFSC Code / IBAN :- {{ @$secondBeneficiary?->meta['iban_number'] }} @endisset</br></div><div class="mt-1">Amount To Send :- {{ $transferDetails['amount'] }} {{ $sender->currency }} </br></div><div class="mt-1">Payment Method :- {{ $transferDetails['payment_method'] }} </br></div><div class="mt-1">Transfer Reason :- {{ @$transferReason['reason'] }} </br></div></div>',
                    15, 15, {
                        'width': 170,
                        'elementHandlers': specialElementHandlers
                    });
                doc.save(type+'-transfer-bank-detail.pdf');
            }
        }

        function copyToClipboard(text, el) {
            var copyTest = document.queryCommandSupported('copy');
            var elOriginalText = el.attr('data-original-title');

            if (copyTest === true) {
                var copyTextArea = document.createElement("textarea");
                copyTextArea.value = text;
                document.body.appendChild(copyTextArea);
                copyTextArea.select();
                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'Copied!' : 'Whoops, not copied!';
                    el.attr('data-original-title', msg).tooltip('show');
                } catch (err) {
                    console.log('Oops, unable to copy');
                }
                document.body.removeChild(copyTextArea);
                el.attr('data-original-title', elOriginalText);
            } else {
                // Fallback if browser doesn't support .execCommand('copy')
                window.prompt("Copy to clipboard: Ctrl+C or Command+C, Enter", text);
            }
        }

        function copyData(the) {
            var text = $(the).attr('data-copy');
            var el = $(the);
            copyToClipboard(text, el);
        }
    </script>
@endpush
