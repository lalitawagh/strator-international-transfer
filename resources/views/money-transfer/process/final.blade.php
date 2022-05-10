@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
<div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
    <div class="col-span-12 lg:col-span-12">

        <!-- BEGIN: Horizontal Form -->
        <!-- BEGIN: Modal Content -->
        <div id="button-modal-preview" class="" tabindex="-1" aria-hidden="true">
            <div class="">
                <div class="">
                    <div class="modal-body py-10">
                        <div class="pb-20 text-center">
                            <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Money Transfer Successful</div>
                            <a href="javascript:;" data-toggle="modal" data-target="#superlarge-slide-over-size-preview" class="btn btn-secondary mb-2 mr-1 mt-5">I've made my bank transfer</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END: Modal Content -->
        <div id="superlarge-slide-over-size-preview" class="modal modal-slide-over" tabindex="-1" aria-hidden="true" style="padding-left: 0px;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h2 class="font-medium text-base mr-auto">
                            All activity
                        </h2>
                    </div>
                    <div class="modal-body">
                        <div class="intro-y flex flex-col sm:flex-row items-center mt-0">
                            <h2 class="text-lg text-theme-1 dark:text-theme-10 font-medium mr-auto">
                                {{  trans('international-transfer::configuration.'.$transaction->status) }}
                            </h2>
                        </div>
                        <div class="intro-y col-span-12 md:col-span-12 mt-3">
                            <div class="box bg-gray-300">
                                <div class="flex flex-col lg:flex-row items-center p-5">
                                    <div class="w-12 h-12 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                        <a href="http://localhost:8000/workspaces/profile"
                                            class="bg-gray-200 p-3 rounded-full text-theme-1 flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-send w-6 h-6">
                                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                            </svg>
                                        </a>

                                    </div>
                                    <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                        <a href="" class="font-medium">To {{ $transaction->meta['second_beneficiary_name'] }}</a>
                                        <div class="text-gray-600 text-xs mt-0.5">Sending</div>
                                    </div>

                                    <div class="lg:ml-2 lg:ml-auto text-center lg:text-right mt-3 lg:mt-0">
                                        <a href="" class="font-medium">{{ @$transaction->meta['recipient_amount'] }} {{ @$transaction->meta['exchange_currency'] }}</a>
                                        <div class="text-gray-600 text-xs mt-0.5">{{ $transaction->amount }} {{ strtoupper($transaction->settled_currency) }}</div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="intro-y col-span-12 md:col-span-12 mt-3">
                            <div class="box">
                                <div class="flex flex-col lg:flex-row items-center p-5">
                                    <table class="relative ttt">
                                        <tr>
                                            <td><span>Today at {{ $transaction->created_at->format('H:i A') }} </span></td>
                                            <td class="list-dot"></td>
                                            <td style="padding-left: 60px;">
                                                <p>
                                                    You set up your transfer
                                                    Your money on its way to us
                                                    Your bank might take some time to get it us. we'll let
                                                    you know when it arrives
                                                </p>
                                            </td>
                                        </tr>
                                        @if($transaction->status == \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::ACCEPTED)
                                        <tr>
                                            <td><span>Today at {{ $transaction->updated_at->format('H:i A') }} </span></td>
                                            <td class="list-dot"></td>
                                            <td style="padding-left: 60px;">
                                                <p>
                                                    We receive your {{ strtoupper($transaction->settled_currency) }}
                                                </p>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
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
