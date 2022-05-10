@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">

        <form method="GET"
            action="{{ route('dashboard.international-transfer.money-transfer.final', ['filter' => ['workspace_id' => $workspace->id]]) }}">

            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Horizontal Form -->
                <div class="intro-y box mt-0 clearfix">
                    <div class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md sm:p-5 m-3">
                        @if ($transferDetails['transaction']->payment_method == \Kanexy\InternationalTransfer\Enums\PaymentMethod::MANUAL_TRANSFER)
                            <div class="sm:flex text-lg text-theme-1 dark:text-theme-10 font-medium mt-2">
                                <h3 class="mr-auto mb-3">Bank transfer details</h3>
                                <div class="text-xs text-right sm:ml-auto flex mb-3">
                                    <a target="_blank" href="https://mail.google.com/mail/u/0/?fs=1&tf=cm&subject=Manually transfer Account Detail&body= Beneficiary :- {{ $beneficiary->display_name }} %0D%0A Payment reference :- {{ @$transferDetails['transaction']->meta['reference_no'] }} %0D%0A Amount To Send:- {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }}
                                            %0D%0A Bank Account Name:- {{ $masterAccount['account_holder_name'] }} %0D%0A Account Number :- {{ $masterAccount['account_number'] }} %0D%0A Sort Code :- {{ $masterAccount['sort_code'] }}  ">
                                        <i data-feather="share-2" class="notification__icon dark:text-gray-300"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="get_pdf('manual')"><i data-feather="download" class="dark:text-gray-300 block mx-auto mr-2"></i></a>
                                    <a onclick="copyData(this)"
                                        data-copy="Manually transfer Account Detail- Beneficiary :- {{ $beneficiary->display_name }}  Payment reference :- {{ @$transferDetails['transaction']->meta['reference_no'] }}  Amount To Send:- {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }}
                                            Bank Account Name:- {{ $masterAccount['account_holder_name'] }}  Account Number :- {{ $masterAccount['account_number'] }}  Sort Code :- {{ $masterAccount['sort_code'] }}  "
                                        href="javascript:void(0);">
                                        <i data-feather="copy" class="dark:text-gray-300 block mx-auto mr-2"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="px-5 sm:px-0 flex flex-col-reverse sm:flex-row grid grid-cols-12 gap-2">
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600 mr-2">Payee name</div>
                                    <div class="text-lg text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ $beneficiary->display_name }}</div>
                                </div>
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600  mr-2">Payment reference </div>
                                    <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ @$transferDetails['transaction']->meta['reference_no'] }}</div>
                                </div>
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600  mr-2">Amount to send </div>
                                    <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ $transferDetails['transaction']->amount }}
                                        {{ $transferDetails['transaction']->settled_currency }}</div>
                                </div>
                            </div>

                            <div class="sm:flex text-lg text-theme-1 dark:text-theme-10 font-medium mt-10">
                                <h3 class="mr-auto mb-3">Bank account details for manually transfer</h3>
                            </div>
                            <div class="px-5 mt-5 sm:px-0 flex flex-col-reverse sm:flex-row grid grid-cols-12 gap-2">
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600  mr-2">Bank Account Name </div>
                                    <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ $masterAccount['account_holder_name'] }}</div>
                                </div>
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600  mr-2">Bank Account Number </div>
                                    <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ $masterAccount['account_number'] }}</div>
                                </div>
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600  mr-2">Bank Account Sort Code </div>
                                    <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0">
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
                            <div class="sm:flex text-lg text-theme-1 dark:text-theme-10 font-medium mt-2">
                                <h3 class="mr-auto mb-3">
                                    {{ $payment }} transfer details
                                </h3>
                                <div class="text-xs text-right sm:ml-auto flex mb-3">
                                    <a target="_blank" href="https://mail.google.com/mail/u/0/?fs=1&tf=cm&subject={{ $payment }} transfer Account Detail&body= Recipient Name :- {{ $transaction->meta['second_beneficiary_name'] }} %0D%0A Recipient Account Number :- {{ $transaction->meta['second_beneficiary_bank_account_number'] }} %0D%0A Recipient Sort Number:- {{ $transaction->meta['second_beneficiary_bank_code'] }}
                                            %0D%0A Amount To Send:- {{ $transaction->amount }} {{ $transaction->settled_currency }} %0D%0A Payment Method :- {{ $transaction->payment_method }} %0D%0A Transfer Reason :- {{ @$transferReason['reason'] }}  ">
                                        <i data-feather="share-2" class="dark:text-gray-300 block mx-auto mr-2"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="get_pdf('{{ $payment }}')"><i data-feather="download" class="dark:text-gray-300 block mx-auto mr-2"></i></a>
                                    <a onclick="copyData(this)"
                                        data-copy="{{ $payment }} transfer Account Detail- Recipient Name :- {{ $transaction->meta['second_beneficiary_name'] }}  Recipient Account Number :- {{ $transaction->meta['second_beneficiary_bank_account_number'] }}  Recipient Sort Number:- {{ $transaction->meta['second_beneficiary_bank_code'] }}
                                             Amount To Send:- {{ $transaction->amount }} {{ $transaction->settled_currency }}  Payment Method :- {{ $transaction->payment_method }}  Transfer Reason :- {{ @$transferReason['reason'] }} "
                                        href="javascript:void(0);">
                                        <i data-feather="copy" class="dark:text-gray-300 block mx-auto mr-2"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="px-5 sm:px-0 flex flex-col-reverse sm:flex-row grid grid-cols-12 gap-2">
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600 mr-2">Recipient Name</div>
                                    <div class="text-lg text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ $transaction->meta['second_beneficiary_name'] }}</div>
                                </div>
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600  mr-2">Recipient Account Number </div>
                                    <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ $transaction->meta['second_beneficiary_bank_account_number'] }}</div>
                                </div>
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600  mr-2">Recipient Sort Number </div>
                                    <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ $transaction->meta['second_beneficiary_bank_code'] }}</div>
                                </div>
                            </div>

                            <div class="px-5 mt-5 sm:px-0 flex flex-col-reverse sm:flex-row grid grid-cols-12 gap-2">
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600  mr-2">Amount To Send </div>
                                    <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ $transaction->amount }} {{ $transaction->settled_currency }}</div>
                                </div>
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600  mr-2">Payment Method </div>
                                    <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ ucfirst($transaction->payment_method) }}</div>
                                </div>
                                <div
                                    class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                                    <div class="text-base text-gray-600  mr-2">Transfer Reason </div>
                                    <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0">
                                        {{ @$transferReason['reason'] }}</div>
                                </div>
                            </div>
                        @endif


                    </div>
                    <div class="my-5 px-3 text-right">
                        <a href="{{ route('dashboard.international-transfer.money-transfer.cancelTransfer', $transferDetails['transaction']->id) }}"
                            class="btn btn-primary text-center mr-1 mb-2 ml-auto">Cancel this transfer</a>
                    </div>

                </div>
            </div>
            <div class="text-right mt-5  py-4">
                <button class="btn btn-secondary w-24">Previous</button>
                <button type="submit" class="btn btn-primary w-24 ml-2">Continue</button>
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
                    '<h2>Manually Transfer Account Details</h2><div><div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2"> Beneficiary :- {{ $beneficiary->display_name }} </br></div><div class="mt-1">Payment reference :- {{ @$transferDetails['transaction']->meta['reference_no'] }} </br></div><div class="mt-1">Amount to send :- {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }} </br></div><div class="mt-1">Bank Account Name :- {{ $masterAccount['account_holder_name'] }} </br></div><div class="mt-1">Bank Account Number :- {{ $masterAccount['account_number'] }} </br></div><div class="mt-1">Bank Sort Code :- {{ $masterAccount['sort_code'] }} </br></div></div>',
                    15, 15, {
                        'width': 170,
                        'elementHandlers': specialElementHandlers
                    });
                doc.save('manually-transfer-bank-detail.pdf');
            } else {
                doc.fromHTML(
                    '<h2>'+type+' Transfer Account Details</h2><div><div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2"> Recipient Name :- {{ $transaction->meta['second_beneficiary_name'] }} </br></div><div class="mt-1">Recipient Account Number :- {{ $transaction->meta['second_beneficiary_bank_account_number'] }} </br></div><div class="mt-1">Recipient Sort Number :- {{ $transaction->meta['second_beneficiary_bank_code'] }} </br></div><div class="mt-1">Amount To Send :- {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }} </br></div><div class="mt-1">Payment Method :- {{ $transaction->payment_method }} </br></div><div class="mt-1">Transfer Reason :- {{ @$transferReason['reason'] }} </br></div></div>',
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
