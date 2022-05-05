@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
<div  class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
    <form method="GET" action="{{ route('dashboard.international-transfer.money-transfer.final',['filter' => ['workspace_id' => $workspace->id]]) }}">
        @csrf
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Horizontal Form -->
            <div class="intro-y box mt-0 clearfix">
                <div class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md sm:p-5 m-3">
                    <div class="sm:flex text-lg text-theme-1 dark:text-theme-10 font-medium mt-2">
                        <h3 class="mr-auto mb-3">Bank transfer details</h3>
                        <div class="text-xs text-right sm:ml-auto flex mb-3">
                            <a target="_blank"  href="https://mail.google.com/mail/u/0/?fs=1&tf=cm&subject=Manually transfer Account Detail&body= Beneficiary :- {{ $beneficiary->display_name }} %0D%0A Payment reference :- {{ $transferDetails['transaction']->meta['reference_no'] }} %0D%0A Amount To Send:- {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }}
                                %0D%0A Bank Account Name:- {{ $masterAccount['account_holder_name'] }} %0D%0A Account Number :- {{ $masterAccount['account_number'] }} %0D%0A Sort Code :- {{ $masterAccount['sort_code'] }}  ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2 block mx-auto mr-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                            </a>
                            <a href="javascript:void(0);" onclick="get_pdf()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download block mx-auto mr-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a>
                            <a onclick="copyData(this)" data-copy="Manually transfer Account Detail- Beneficiary :- {{ $beneficiary->display_name }}  Payment reference :- {{ $transferDetails['transaction']->meta['reference_no'] }}  Amount To Send:- {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }}
                                Bank Account Name:- {{ $masterAccount['account_holder_name'] }}  Account Number :- {{ $masterAccount['account_number'] }}  Sort Code :- {{ $masterAccount['sort_code'] }}  " href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy block mx-auto mr-2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            </a>
                        </div>
                    </div>
                    @if ($transferDetails['transaction']->payment_method == \Kanexy\InternationalTransfer\Enums\PaymentMethod::MANUALLY_TRANSFER)
                    <div class="px-5 sm:px-0 flex flex-col-reverse sm:flex-row grid grid-cols-12 gap-2">
                        <div class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                            <div class="text-base text-gray-600 mr-2">Payee name</div>
                            <div class="text-lg text-theme-1 dark:text-theme-10 font-medium mt-0">{{ $beneficiary->display_name }}</div>
                        </div>
                        <div class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                            <div class="text-base text-gray-600  mr-2">Payment reference </div>
                            <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0"> {{ $transferDetails['transaction']->meta['reference_no'] }}</div>
                        </div>
                        <div class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                            <div class="text-base text-gray-600  mr-2">Amount to send </div>
                            <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0"> {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }}</div>
                        </div>
                    </div>

                    <div class="sm:flex text-lg text-theme-1 dark:text-theme-10 font-medium mt-10">
                        <h3 class="mr-auto mb-3">Bank account details for manually transfer</h3>
                    </div>
                    <div class="px-5 mt-5 sm:px-0 flex flex-col-reverse sm:flex-row grid grid-cols-12 gap-2">
                        <div class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                            <div class="text-base text-gray-600  mr-2">Bank Account Name </div>
                            <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0"> {{ $masterAccount['account_holder_name'] }}</div>
                        </div>
                        <div class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                            <div class="text-base text-gray-600  mr-2">Bank Account Number </div>
                            <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0"> {{ $masterAccount['account_number'] }}</div>
                        </div>
                        <div class="sm:flex text-center sm:text-left sm-mt-3 sm:mt-0 col-span-12 md:col-span-4 lg:col-span-4 form-inline">
                            <div class="text-base text-gray-600  mr-2">Bank Account Sort Code </div>
                            <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-0"> {{ $masterAccount['sort_code'] }}</div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="my-5 px-3 text-right">
                    <a href="{{ route('dashboard.international-transfer.money-transfer.cancelTransfer',$transferDetails['transaction']->id) }}" class="btn btn-primary text-center mr-1 mb-2 ml-auto">Cancel this transfer</a>
                    <a href="javascript:;" data-toggle="modal" data-target="#superlarge-slide-over-size-preview" class="btn btn-secondary mb-2 mr-1">I've made my bank transfer</a>
                    <button class="btn btn-secondary mb-2">I'll transfer my money later</button>
                </div>

            </div>
        </div>
        <div class="text-right mt-5  py-4">
            <button class="btn btn-secondary w-24" >Previous</button>
            <button type="submit" class="btn btn-primary w-24 ml-2">Continue</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>

<script>

    function get_pdf() {
        var doc = new jsPDF();
        var specialElementHandlers = {
        '#editor': function(element, renderer) {
            return true;
        }
        };

        doc.fromHTML('<h2>Manually Transfer Account Details</h2><div><div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2"> Beneficiary :- {{ $beneficiary->display_name }} </br></div><div class="mt-1">Payment reference :- {{ $transferDetails['transaction']->meta['reference_no'] }} </br></div><div class="mt-1">Amount to send :- {{ $transferDetails['transaction']->amount }} {{ $transferDetails['transaction']->settled_currency }} </br></div><div class="mt-1">Bank Account Name :- {{ $masterAccount['account_holder_name'] }} </br></div><div class="mt-1">Bank Account Number :- {{ $masterAccount['account_number'] }} </br></div><div class="mt-1">Bank Sort Code :- {{ $masterAccount['sort_code'] }} </br></div></div>', 15, 15, {
        'width': 170,
        'elementHandlers': specialElementHandlers
        });
        doc.save('manually-transfer-bank-detail.pdf');


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

    function copyData(the){
        var text = $(the).attr('data-copy');
        var el = $(the);
        copyToClipboard(text, el);
    }
</script>
@endpush
