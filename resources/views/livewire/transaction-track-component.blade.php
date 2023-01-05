<div>
    @isset($transaction)
        <div class="intro-y flex flex-col sm:flex-row items-center mt-0">
            <h2 class="text-lg text-theme-1 dark:text-theme-10 font-medium mr-auto">
                {{ trans('international-transfer::configuration.' . $transaction?->status) }}
            </h2>
        </div>
        <div class="intro-y col-span-12 md:col-span-12 mt-3">
            <div class="box bg-gray-300">
                <div class="flex flex-col lg:flex-row items-center p-5">
                    {{-- <div class="w-12 h-12 lg:w-12 lg:h-12 image-fit lg:mr-1">
                        <a href="http://localhost:8000/workspaces/profile"
                            class="bg-gray-200 p-3 rounded-full text-theme-1 flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-send w-6 h-6">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </a>

                    </div> --}}
                    <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                        <a id="SecondBeneficiary" href="" class="font-medium">To
                            {{ $transaction->meta['second_beneficiary_name'] }}</a>
                    </div>

                    <div class="lg:ml-2 lg:ml-auto text-center lg:text-right mt-3 lg:mt-0">
                        <a id="RecipientAmount" href=""
                            class="font-medium">{{ @$transaction->meta['recipient_amount'] }}
                            {{ @$transaction->meta['exchange_currency'] }}</a>
                        <div class="text-gray-600 text-xs mt-0.5">{{ $transaction->amount }}
                            {{ strtoupper($transaction->settled_currency) }}</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="intro-y col-span-12 md:col-span-12 mt-3">
            <div class="box">
                <div class="flex flex-col lg:flex-row items-center p-5">
                    <table class="relative ttt">
                        <tr>
                            <td><span>{{ $transaction->updated_at->format('d M Y') }},
                                    {{ $transaction->created_at->format('H:i A') }} </span></td>
                            <td class="list-dot"></td>
                            <td style="padding-left: 60px;">
                                <p>
                                    Transaction is initiated. Please stay with us for further updates.
                                </p>
                            </td>
                        </tr>

                        @if ($transaction->status == \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::CANCELLED)
                            <tr>
                                <td><span>{{ $transaction->updated_at->format('d M Y') }},
                                        {{ $transaction->updated_at->format('H:i A') }} </span></td>
                                <td class="list-dot"></td>
                                <td style="padding-left: 60px;">
                                    <p>
                                        Transaction cancelled successfully.
                                    </p>
                                </td>
                            </tr>
                        @endif

                        @if ($transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED &&
                            $transaction->status != \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::CANCELLED)
                            <tr>
                                <td><span>{{ $transaction->updated_at->format('d M Y') }},
                                        {{ $transaction->updated_at->format('H:i A') }} </span></td>
                                <td class="list-dot"></td>
                                <td style="padding-left: 60px;">
                                    <p>
                                        Transaction {{ $transaction->status }}.
                                    </p>
                                </td>
                            </tr>
                        @endif

                        @if ($transaction->status == \Kanexy\PartnerFoundation\Banking\Enums\TransactionStatus::COMPLETED)
                            <tr>
                                <td><span>{{ $transaction->updated_at->format('d M Y') }},
                                        {{ $transaction->updated_at->format('H:i A') }} </span></td>
                                <td class="list-dot"></td>
                                <td style="padding-left: 60px;">
                                    <p>
                                        Transaction completed Sucessfully.
                                    </p>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    @endisset
</div>
