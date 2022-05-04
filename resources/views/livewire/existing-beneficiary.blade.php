<div>
    <div class="grid rounded-lg w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5 mt-5 pt-3">
        <div class="font-medium text-base col-span-12 sm:col-span-12 xxl:col-span-12 py-3"> Existing Beneficiary</div>
        <div class="intro-y col-span-12 lg:col-span-12" style="max-height:400px;overflow-y:auto;">
            @foreach ($beneficiaries as $beneficiary)
                @php
                    $sender = \Kanexy\Cms\I18N\Models\Country::find(@$beneficiary->meta['sending_currency']);
                    $receiver = Kanexy\Cms\I18N\Models\Country::find(@$beneficiary->meta['receiving_currency']);
                @endphp
                <div class="relative flex items-center py-2 border-t border-gray-200"
                    wire:click="getBeneficiary({{ $beneficiary->id }})">
                    <div
                        class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
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
                            {{ substr(@$beneficiary->meta['account_number'], 4) }}</div>

                    </div>
                </div>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center"><svg
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
            <button type="button" wire:click="load" class="btn btn-primary w-24 mb-10">Load More</button>
        </div>

    </div>

    @isset($beneficiaryDetail)
        <!-- BEGIN: Modal Content -->
            <div id="confirm-beneficiary-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="p-5 text-center">
                                <div class="relative flex items-center p-6">
                                    <div class="w-16 h-16 flex-none image-fit w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
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
                                <div class="col-span-12 md:col-span-6 form-inline pl-6 pr-6 ">
                                    <label for="type" class="form-label sm:w-48 font-small">Email </label>
                                    <div class="sm:w-4/6">
                                        <span>{{ @$beneficiaryDetail->email }}</span>
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline pl-6 pr-6 ">
                                    <label for="type" class="form-label sm:w-48 font-small">Sort Code / IFSC Code </label>
                                    <div class="sm:w-4/6">
                                        <span>{{ @$beneficiaryDetail->meta['sort_no'] }}</span>
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline pl-6 pr-6 ">
                                    <label for="type" class="form-label sm:w-48">Account Number </label>
                                    <div class="sm:w-4/6">
                                        <span>{{ @$beneficiaryDetail->meta['account_number'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 text-center border-t border-slate-200/60 dark:border-darkmode-400">
                                <a data-dismiss="modal" class="text-primary">Select another receipient</a>
                                <br>
                                <a href="{{ route('dashboard.international-transfer.money-transfer.payment') }}"
                                    class="btn w-24 mt-3 btn-primary">Continue</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- END: Modal Content -->
    @endisset

</div>
