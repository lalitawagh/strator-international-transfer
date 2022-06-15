<div>
    @if (!isset($transaction))
        <div class="mt-5">
            <svg width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="rgb(45, 55, 72)" class="w-8 h-8 block mx-auto">
                <g fill="none" fill-rule="evenodd">
                    <g transform="translate(1 1)" stroke-width="4">
                        <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle>

                        <path d="M36 18c0-9.94-8.06-18-18-18">
                            <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                        </path>
                    </g>
                </g>
            </svg>
        </div>
    @else
        @isset ($transaction->meta['sender_id'])
            @php
            $sender = \Kanexy\PartnerFoundation\Banking\Models\Account::find($transaction->meta['sender_id']);
            $reference = collect(\Kanexy\Cms\Setting\Models\Setting::getValue('money_transfer_reasons',[]))->firstWhere('id', $transaction->meta['reason']);
            @endphp
        @endisset

        <div class="grid grid-cols-12 gap-4 mt-0">
            <div class="col-span-12 lg:col-span-6 xxl:col-span-6 bg-gray-400 mt-5 px-3 pb-5">
                <div class="mb-2 mt-3 box flex flex-col lg:flex-row items-center px-0 py-2 border-b border-gray-200 dark:border-dark-5">
                    <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                        <img alt="rounded-full" class="" src="../../dist/images/icons/2.png">
                    </div>
                    <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                        <a href="" class="font-medium">{{ $transaction->meta['second_beneficiary_name'] }}</a>
                        <div class="text-gray-600 text-xs mt-0.5">{{ $transaction->urn }}</div>
                    </div>

                </div>
                <div id="faq-accordion-1" class="box accordion accordion-boxed px-2 py-2">
                    <div class="accordion-item">
                        <div id="faq-accordion-content-1" class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-1" aria-expanded="true" aria-controls="faq-accordion-collapse-1"> Sender Account </button>
                        </div>
                        <div id="faq-accordion-collapse-1" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-1" data-bs-parent="#faq-accordion-1">
                            <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            Sender Name
                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            {{ @$transaction->meta['sender_name'] }}
                                        </span>
                                    </div>
                                </div>

                                @if($transaction->payment_method == \Kanexy\InternationalTransfer\Enums\PaymentMethod::STRIPE || $transaction->payment_method == 'bank')
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            @if($transaction->payment_method == \Kanexy\InternationalTransfer\Enums\PaymentMethod::STRIPE)
                                                Sender Payment Id
                                            @else
                                                Account No.
                                            @endif

                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            @if($transaction->payment_method == \Kanexy\InternationalTransfer\Enums\PaymentMethod::STRIPE) {{ @$transaction->meta['sender_payment_id'] }} @else  {{ @$sender->account_number }} @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            @if($transaction->payment_method == \Kanexy\InternationalTransfer\Enums\PaymentMethod::STRIPE)
                                                Sender Card Id
                                            @else
                                                Sort Code
                                            @endif
                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            @if($transaction->payment_method == \Kanexy\InternationalTransfer\Enums\PaymentMethod::STRIPE)  {{ @$transaction->meta['sender_card_id'] }} @else {{ @$sender->bank_code }} @endif
                                        </span>
                                    </div>
                                </div>

                                @endif
                            </div>
                        </div>
                    </div>

                    @if($transaction->payment_method == \Kanexy\InternationalTransfer\Enums\PaymentMethod::MANUAL_TRANSFER)
                    <div class="accordion-item">
                        <div id="faq-accordion-content-3" class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-3" aria-expanded="false" aria-controls="faq-accordion-collapse-3"> Manual Bank Deposit Account Details </button>
                        </div>
                        <div id="faq-accordion-collapse-3" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-3" data-bs-parent="#faq-accordion-3">
                            <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            Account Name
                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            {{ @$masterAccount['account_holder_name'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            Account No
                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            {{ @$masterAccount['account_number'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            Sort Code
                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            {{ @$masterAccount['sort_code'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            Reference Number
                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            {{ @$transaction->meta['reference_no'] }}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="accordion-item">
                        <div id="faq-accordion-content-2" class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-2" aria-expanded="false" aria-controls="faq-accordion-collapse-2"> Receiver Account</button>
                        </div>
                        <div id="faq-accordion-collapse-2" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-2" data-bs-parent="#faq-accordion-1">
                            <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            Receiver Name
                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            {{ @$transaction->meta['second_beneficiary_name'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            Account No
                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            {{ @$transaction->meta['second_beneficiary_bank_account_number'] }}
                                        </span>
                                    </div>
                                </div>
                                @isset($transaction->meta['second_beneficiary_bank_code'])
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            Sort Code
                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            {{ @$transaction->meta['second_beneficiary_bank_code'] }}
                                        </span>
                                    </div>
                                </div>
                                @endisset

                                @isset($transaction->meta['second_beneficiary_bank_iban'])
                                <div class="sm:flex lg:flex-row mt-2">
                                    <div class="truncate sm:whitespace-normal sm:w-1/2 w-auto flex items-center">
                                        <span>
                                            IFSC Code / IBAN
                                        </span>
                                    </div>
                                    <div class="sm:whitespace-normal items-center sm:text-right sm:w-3/2 sm:ml-auto">
                                        <span class="font-medium">
                                            {{ @$transaction->meta['second_beneficiary_bank_iban'] }}
                                        </span>
                                    </div>
                                </div>
                                @endisset
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-span-12 lg:col-span-6 xxl:col-span-6  mt-5 px-3 pb-5">
                <div class="intro-y col-span-12 lg:col-span-12 px-0">
                    <div class="flex flex-col lg:flex-row px-0 sm:px-0 py-0 mb-2">
                        <div class="dark:text-theme-10">
                            <p class="text-xl font-medium @if ($transaction->type === 'debit') text-theme-6 @else text-theme-9 @endif">
                                @if (isset($transaction->meta['transaction_type']) && $transaction->meta['transaction_type'] == 'deposit')  @else  @endif  {{ \Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($transaction->amount,$transaction->meta['base_currency']) }}
                                @if (isset($transaction->meta['transaction_type']) && $transaction->meta['transaction_type'] == 'deposit')
                                    <span class="text-sm font-medium text-gray-700 md:ml-4">Deposit / {{ \Illuminate\Support\Str::title(implode(' ', explode('-', $transaction->status))) }}</span>
                                @else
                                    <span class="text-sm font-medium text-gray-700 md:ml-4">@if ($transaction->type === 'debit') Paid Out @else Paid In @endif / {{ \Illuminate\Support\Str::title(implode(' ', explode('-', $transaction->status))) }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if ($transaction->status !== 'accepted' && $transaction->reasons !== null && count($transaction->reasons) > 0)
                        <div class="alert @if ($transaction->status === 'declined') alert-danger @endif alert-warning show my-6" role="alert">
                            <div class="flex items-center">
                                <div class="font-medium text-lg">Additional Information</div>
                            </div>

                            <div class="mt-3">
                                <ul class="list-disc mx-4">
                                    @foreach ($transaction->reasons as $reason)
                                        <li>{{ $reason }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="grid grid-cols-12 flex flex-wrap sm:gap-4">
                    <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                        <p class="text-sm tracking-wide font-medium uppercase">Created At</p>

                        <div class="flex flex-col lg:flex-row mt-1">
                            <div class="truncate sm:whitespace-normal flex items-center">
                                {{-- <x-feathericon-clock height="12"/> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>

                                <span>
                                    {{ $transaction->getLastProcessDateTime()->format($defaultDateFormat . ' ' . $defaultTimeFormat) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                        <p class="text-sm tracking-wide font-medium uppercase">Transfer Type</p>

                        <div class="flex flex-col lg:flex-row mt-1">
                            <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">
                                <x-feathericon-globe height="12"/>

                                <span>
                                    {{ ucfirst($transaction->payment_method) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                        <p class="text-sm tracking-wide font-medium uppercase">Sending Currency</p>

                        <div class="flex flex-col lg:flex-row mt-1">
                            <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">
                                <x-feathericon-send height="12"/>

                                <span>
                                    {{ $transaction->meta['base_currency'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                        <p class="text-sm tracking-wide font-medium uppercase">Receiving Currency</p>

                        <div class="flex flex-col lg:flex-row mt-1">
                            <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">
                                <x-feathericon-pocket height="12"/>

                                <span>
                                    {{ $transaction->meta['exchange_currency'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                        <p class="text-sm tracking-wide font-medium uppercase">Sending Amount</p>

                        <div class="flex flex-col lg:flex-row mt-1">
                            <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">

                                <span>
                                    {{ \Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($transaction->amount,$transaction->meta['base_currency']) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                        <p class="text-sm tracking-wide font-medium uppercase">Receiving Amount</p>

                        <div class="flex flex-col lg:flex-row mt-1">
                            <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">

                                <span>
                                    {{ \Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($transaction->meta['recipient_amount'],$transaction->meta['exchange_currency']) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                        <p class="text-sm tracking-wide font-medium uppercase">Exchange Rate</p>

                        <div class="flex flex-col lg:flex-row mt-1">
                            <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">
                                <x-feathericon-repeat height="12"/>
                                <span>
                                    {{ @$transaction->meta['exchange_rate'] }}
                                </span>
                            </div>
                        </div>
                    </div>



                    @isset($transaction->meta['reason'])
                        <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                            <p class="text-sm tracking-wide font-medium uppercase">Transfer Reason</p>

                            <div class="flex flex-col lg:flex-row mt-1">
                                <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">
                                    <span>
                                        {{ @$reference['reason'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endisset



                    <div class="saved-transaction col-span-12 lg:col-span-12 xxl:col-span-12 mt-2">

                        @isset($transaction->attachment)
                        <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                            <p class="text-sm tracking-wide font-medium uppercase">Attachment</p>

                            <div class="flex flex-col lg:flex-row mt-1">
                                <div class="truncate sm:whitespace-normal flex items-center">
                                    <img width="100" height="100" src="{{ \Illuminate\Support\Facades\Storage::disk('azure')->url($transaction->attachment) }}" />
                                </div>
                            </div>
                        </div>
                        @endisset

                        @isset($transaction->note)
                        <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                            <p class="text-sm tracking-wide font-medium uppercase">Note</p>

                            <div class="flex flex-col lg:flex-row mt-1">
                                <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">
                                    <span>
                                        {{ $transaction->note }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endisset
                    </div>

                    <div class="edit-transaction-content col-span-12 lg:col-span-12 xxl:col-span-12 mt-2 hidden">
                        <form id="transaction-form" action="{{ route('dashboard.banking.transactions.update', $transaction->getKey()) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                                <p class="text-sm tracking-wide font-medium uppercase">Attachment</p>

                                <div class="flex flex-col lg:flex-row mt-1">
                                    <div class="truncate sm:whitespace-normal flex items-center">
                                        @isset($transaction->attachment)
                                            <img width="100" height="100" src="{{ \Illuminate\Support\Facades\Storage::disk('azure')->url($transaction->attachment) }}" />
                                        @endisset
                                        <input type="file" id="attachment" name="attachment" class="ml-2 w-full" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12 lg:col-span-6 xxl:col-span-6 mt-2">
                                <p class="text-sm tracking-wide font-medium uppercase">Note</p>

                                <div class="flex-col lg:flex-row mt-1">
                                    <div class="truncate sm:whitespace-normal flex items-center">
                                        <textarea id="note" name="note" class="form-control w-full" value="{{ $transaction->note }}">{{ $transaction->note }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>
@push('scripts')
<script>
    $(".edit-transaction").removeClass('hidden');
    $(".edit-transaction").addClass('flex');
    $(".save-transaction").addClass('hidden');
    $(".save-transaction").click(function(){
        $("#transaction-form").submit();
    });

    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('element.updated', (el, component) => {
            feather.replace();
        });
    });

    $(".edit-transaction").click(function(){
        $(this).addClass('hidden');
        $("#attachment").val('');
        $("#note").val('');
        $(".edit-transaction-content").removeClass('hidden');
        $(".edit-transaction-content").addClass('flex');
        $(".save-transaction").removeClass('hidden');
        $(".save-transaction").addClass('flex');
        $(".saved-transaction").addClass('hidden');
    });




</script>
@endpush
