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
        @php

        @endphp
        <div>
            <div class="flex flex-col lg:flex-row px-1 sm:px-2 py-0 mb-2">
                <div class="dark:text-theme-10">
                    <p class="text-xl font-medium @if ($transaction->type === 'debit') text-theme-6 @else text-theme-9 @endif">
                        @if (isset($transaction->meta['transaction_type']) && $transaction->meta['transaction_type'] == 'deposit')  @else  @endif {{ number_format((float)$transaction->amount, 2, '.', '') }}
                        @if (isset($transaction->meta['transaction_type']) && $transaction->meta['transaction_type'] == 'deposit')
                            <span class="text-sm font-medium text-gray-700 md:ml-4">Deposit / {{ \Illuminate\Support\Str::title(implode(' ', explode('-', $transaction->status))) }}</span>
                        @else
                            <span class="text-sm font-medium text-gray-700 md:ml-4">@if ($transaction->type === 'debit') Paid Out @else Paid In @endif / {{ \Illuminate\Support\Str::title(implode(' ', explode('-', $transaction->status))) }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row px-1 sm:px-2 py-0 mb-2">
                <div class="dark:text-theme-10">
                    <h2 class="text-theme-1 dark:text-theme-10 font-semibold text-2xl">{{ $transaction->meta['second_beneficiary_name'] }}</h2>
                    <p class="text-sm font-medium text-gray-700">{{ $transaction->urn }}</p>
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

            <div class="mt-5">
                <p class="text-sm tracking-wide font-medium uppercase">Basic Details</p>

                <div class="flex flex-col lg:flex-row mt-3">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <x-feathericon-globe height="12"/>

                        <span>
                            {{ ucfirst($transaction->payment_method) }}
                        </span>
                    </div>

                    <div class="truncate sm:whitespace-normal flex items-center md:ml-4">
                        <x-feathericon-clock height="12"/>

                        <span>
                            {{ $transaction->getLastProcessDateTime()->format($defaultDateFormat . ' ' . $defaultTimeFormat) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-5 float-right">
                <p class="text-sm tracking-wide font-medium uppercase">Receiver Currency</p>

                <div class="flex flex-col lg:flex-row mt-3">
                    <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">
                        <x-feathericon-pocket height="12"/>

                        <span>
                            {{ $transaction->meta['exchange_currency'] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <p class="text-sm tracking-wide font-medium uppercase">Sending Currency</p>

                <div class="flex flex-col lg:flex-row mt-3">
                    <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">
                        <x-feathericon-send height="12"/>

                        <span>
                            {{ $transaction->meta['base_currency'] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-5 float-right">
                <p class="text-sm tracking-wide font-medium uppercase">Beneficiary Account</p>

                <div class="flex flex-col lg:flex-row mt-3">
                    <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">
                        <x-feathericon-user height="12"/>

                        <span>
                            {{ $transaction->meta['second_beneficiary_name'] }}
                        </span>
                    </div>
                    @isset($transaction->meta['beneficiary_bank_account_number'])
                    <div class="sm:whitespace-normal flex items-center sm:w-2/6 md:ml-0">
                        <x-feathericon-globe height="12"/>

                        <span class="font-medium">
                            {{ $transaction->meta['beneficiary_bank_code'] }} / {{ $transaction->meta['beneficiary_bank_account_number'] }}
                        </span>
                    </div>
                    @endisset
                </div>
            </div>

            <div class="mt-5">
                <p class="text-sm tracking-wide font-medium uppercase">Sender Account</p>

                <div class="flex flex-col lg:flex-row mt-3">
                    <div class="truncate sm:whitespace-normal sm:w-4/5 w-auto flex items-center">
                        <x-feathericon-user height="12"/>

                        <span>
                            {{ @$transaction->meta['sender_name'] }}
                        </span>
                    </div>
                </div>
            </div>

            @isset($transaction->meta['reference'])
                <div class="mt-5">
                    <p class="text-sm tracking-wide font-medium uppercase">Reference</p>

                    <div class="flex flex-col lg:flex-row mt-3">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span>
                                {{ $transaction->meta['reference'] }}
                            </span>
                        </div>
                    </div>
                </div>
            @endisset

            <div class="saved-transaction">

                @isset($transaction->attachment)
                <div class="mt-5">
                    <p class="text-sm tracking-wide font-medium uppercase">Attachment</p>

                    <div class="flex flex-col lg:flex-row mt-3">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <img width="100" height="100" src="{{ \Illuminate\Support\Facades\Storage::disk('azure')->url($transaction->attachment) }}" />
                        </div>
                    </div>
                </div>
                @endisset

                @isset($transaction->note)
                <div class="mt-5">
                    <p class="text-sm tracking-wide font-medium uppercase">Note</p>

                    <div class="flex flex-col lg:flex-row mt-3">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span>
                                {{ $transaction->note }}
                            </span>
                        </div>
                    </div>
                </div>
                @endisset
            </div>

            <div class="edit-transaction-content hidden">
                <form id="transaction-form" action="{{ route('dashboard.international-transfer.transactionsUpdate', $transaction->getKey()) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mt-5">
                        <p class="text-sm tracking-wide font-medium uppercase">Attachment</p>

                        <div class="flex flex-col lg:flex-row mt-3">
                            <div class="truncate sm:whitespace-normal flex items-center">
                                @isset($transaction->attachment)
                                    <img width="100" height="100" src="{{ \Illuminate\Support\Facades\Storage::disk('azure')->url($transaction->attachment) }}" />
                                @endisset
                                <input type="file" id="attachment" name="attachment" class="ml-2 w-full" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <p class="text-sm tracking-wide font-medium uppercase">Note</p>

                        <div class="flex flex-col lg:flex-row mt-3">
                            <div class="truncate sm:whitespace-normal flex items-center">
                                <textarea id="note" name="note" class="form-control w-full" value="{{ $transaction->note }}">{{ $transaction->note }}</textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>


        </div>
        <script>
            $(".edit-transaction").removeClass('hidden');
            $(".edit-transaction").addClass('flex');
            $(".save-transaction").addClass('hidden');
            $(".save-transaction").click(function(){
                $("#transaction-form").submit();
            });
        </script>
    @endif
</div>
@push('scripts')
<script>
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
