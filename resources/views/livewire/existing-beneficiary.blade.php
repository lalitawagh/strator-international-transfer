<div>
    <div class="grid rounded-lg w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5 mt-5 pt-3">
        <div class="font-medium text-base col-span-12 sm:col-span-12 xxl:col-span-12 py-3"> Existing Beneficiary</div>
        <div class="intro-y col-span-12 lg:col-span-12" style="max-height:410px;overflow-y:auto;">
            @foreach ($beneficiaries as $beneficiary)
                @php
                    $sender = \Kanexy\Cms\I18N\Models\Country::find(@$beneficiary->meta['sending_currency']);
                    $receiver = Kanexy\Cms\I18N\Models\Country::find(@$beneficiary->meta['receiving_currency']);
                @endphp
                <div class="relative flex items-center py-2 border-t border-gray-200  cursor"
                    wire:click="getBeneficiary({{ $beneficiary->id }})">
                    <div
                        class="dark:bg-darkmode-400 dark:border-darkmode-400 bg-gray-200 w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                        @isset($beneficiary->first_name) {{ ucfirst(substr($beneficiary->first_name, 0, 1)) }}
                            {{ ucfirst(substr($beneficiary->last_name, 0, 1)) }}
                        @else
                            {{ ucfirst(substr($beneficiary->display_name, 0, 1)) }}
                @endif
            </div>
            <div class="ml-4 mr-auto">
                <div class="font-medium">
                    @isset($beneficiary->display_name) {{ $beneficiary->display_name }}
                    @else
                        {{ $beneficiary->first_name }} {{ $beneficiary->last_name }} @endif
                    </div>
                    <div class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                        <div class="mr-2"> <b>{{ @$receiver->currency }} </b> account ending in
                            {{ substr(@$beneficiary->meta['bank_account_number'], -4) }}</div>

                    </div>
                </div>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a id="CurrentColor" href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right w-4 h-4 w-4 h-4">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg></a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="intro-y col-span-12 lg:col-span-12 m-auto">
            <button id="LoadMore" type="button" wire:click="load" class="btn btn-primary w-24 mb-10">Load More</button>
        </div>

        </div>

        @isset($beneficiaryDetail)
            <!-- BEGIN: Modal Content -->
            <div id="confirm-beneficiary-modal-preview" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body p-0">
                            <div class="p-5 text-center">
                                <div class="relative flex items-center p-0">
                                    <div
                                        class="dark:bg-darkmode-400 dark:border-darkmode-400 bg-gray-200  w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                                        @isset($beneficiaryDetail->first_name)
                                            {{ ucfirst(substr($beneficiaryDetail->first_name, 0, 1)) }}{{ ucfirst(substr($beneficiaryDetail->last_name, 0, 1)) }}
                                        @else
                                            {{ ucfirst(substr($beneficiaryDetail->display_name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <div class="font-medium">
                                                @isset($beneficiaryDetail->display_name)
                                                    {{ $beneficiaryDetail->display_name }}
                                                @else
                                                    {{ $beneficiaryDetail->first_name }} {{ $beneficiaryDetail->last_name }}
                                                    @endif
                                                </div>
                                                <div class="w-full flex-column text-gray-600 text-xs sm:text-sm">
                                                    <div class="mr-2"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-5 pb-8 text-center">
                                        <div class="sm:w-52 sm:w-auto mx-auto mt-0">
                                            <div class="flex items-start text-left mt-4">

                                                <span class="font-medium w-2/4 truncate">Account Name</span>
                                                <span
                                                    class="font-medium w-2/3 text-sm break-all">{{ @$beneficiaryDetail->meta['bank_account_name'] }}</span>
                                            </div>

                                            <div class="flex items-start text-left mt-4">

                                                <span class="font-medium w-2/4 truncate">Account Number</span>
                                                <span
                                                    class="font-medium w-2/3 text-sm break-all">{{ @$beneficiaryDetail->meta['bank_account_number'] }}</span>
                                            </div>

                                            <div class="flex items-start text-left mt-4">

                                                <span class="font-medium w-2/4 truncate">IFSC Code / IBAN</span>
                                                <span
                                                    class="font-medium w-2/3 text-sm break-all">{{ @$beneficiaryDetail->meta['iban_number'] }}</span>
                                            </div>
                                            @isset($beneficiaryDetail->meta['bank_code'])
                                                <div class="flex items-start text-left mt-4">

                                                    <span class="font-medium w-2/4 truncate">Sort Code</span>
                                                    <span
                                                        class="font-medium w-2/3 text-sm break-all">{{ @$beneficiaryDetail->meta['bank_code'] }}</span>
                                                </div>
                                            @endisset

                                            @isset($beneficiaryDetail->meta['bank_country'])
                                                <div class="flex items-start text-left mt-4">

                                                    <span class="font-medium w-2/4 truncate">Country</span>
                                                    <span
                                                        class="font-medium w-2/3 text-sm break-all">{{ \Kanexy\Cms\I18N\Models\Country::find($beneficiaryDetail->meta['bank_country'])?->name }}</span>
                                                </div>
                                            @endisset

                                            <div class="flex items-start text-left mt-4">

                                                <span class="font-medium w-2/4 truncate">Type</span>
                                                <span
                                                    class="font-medium w-2/3 text-sm break-all">{{ ucfirst($beneficiaryDetail->type) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex p-5 text-center border-t border-slate-200/60 dark:border-darkmode-400">
                                        <a id="SelectAnotherRecipient" data-tw-dismiss="modal"
                                            class="text-primary pt-3 active-clr cursor">Select another recipient</a>
                                        <br>
                                        <a id="Continue"
                                            href="{{ route('dashboard.international-transfer.money-transfer.payment', ['filter' => ['workspace_id' => $workspace->id]]) }}"
                                            class="btn w-24 mt-0 btn-primary ml-auto">Continue</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Modal Content -->
                @endisset

                </div>
