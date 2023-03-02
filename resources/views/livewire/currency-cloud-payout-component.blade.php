<div>
    {{-- <div id="currency-cloud-payout" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl ihphone-scroll-height">
            <div class="modal-content">
                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Currency Cloud Payout</h2>

                    <a data-tw-dismiss="modal" href="javascript:;">
                        <i data-lucide="x" class="w-8 h-8 text-slate-400"></i>
                    </a>
                    <div class="dropdown hidden">
                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"
                            data-tw-toggle="dropdown">
                            <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i>
                        </a>
                    </div>
                </div>
                <!-- END: Slide Over Header -->

                <form action="{{ route('dashboard.banking.closeledger.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="grid grid-cols-12 md:gap-0 mt-0 ihphone-scroll-height-inr1">
                            <div class="col-span-12 md:col-span-12 lg:col-span-12 sm:col-span-12 form-inline mt-2">
                                <div class="sm:w-5/6">
                                    <input id="payout" class="form-check-input contact-type" type="radio" name="type"value="">
                                    <label class="form-check-label" for="payout">Currency Cloud Payout</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Slide Over Body -->
                    <!-- BEGIN: Slide Over Footer -->
                    <div class="modal-footer
                                w-full bottom-0">
                        <button id="LedgerCancel" type="button" data-tw-dismiss="modal"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button id="LedgerSubmit" type="submit" class="btn btn-primary w-20">Submit</button>
                    </div>
                    <!-- END: Slide Over Footer -->
                </form>
                <!-- BEGIN: Slide Over Body -->
            </div>
        </div>
    </div> --}}
    <div class="py-5">
        <form action="{{ route("currencycloudpayout.store")}}" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" value="{{ $transaction?->id }}" name="payment">
            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-8 mt-0">
                <div class="col-span-12 md:col-span-12 form-inline mt-2" style="align-items: inherit;">
                    <div class="sm:w-5/6">
                        <input id="payout" class="form-check-input contact-type" type="radio" name="type" value="" checked>
                        <label class="form-check-label" for="payout">Currency Cloud Payout</label>
                    </div>
                </div>
            </div>
            <div class="text-right mt-5">
                <button id="PayoutSubmit" type="submit"
                    class="btn btn-sm btn-primary w-24 mr-1">Submit</button>
            </div>
        </form>
    </div>
</div>
