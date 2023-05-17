@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="flex items-center p-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Money Transfer
                    </h2>
                    @if ($user->isSubscriber())
                        @can(\Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy::CREATE,
                            \Kanexy\InternationalTransfer\Contracts\MoneyTransfer::class)
                            <a id="MoneyTransfer"
                                href="{{ route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]) }}"
                                class="btn btn-sm btn-primary sm:ml-2 py-2 sm:mb-2 mb-2">Money
                                Transfer</a>
                        @endcan
                    @endif
                </div>

                <div class="Livewire-datatable-modal pb-3">
                    <livewire:data-table model='Kanexy\InternationalTransfer\Contracts\MoneyTransfer'
                        params="{{ $workspace?->id }}" type='money-transfer' />
                </div>
            </div>
        </div>
    </div>

    <div id="subscription-modal" class="modal modal-slide-over z-50" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header p-3">
                    <h2 class="text-lg font-medium mr-auto">Transfer Details</h2>

                    <a class="close intro-x cursor-pointer w-8 h-8 flex items-center justify-center rounded-full bg-theme-6 text-white ml-2 tooltip"
                        data-tw-dismiss="modal"> <i data-lucide="x" class="w-3 h-3"></i> </a>
                </div>


                <div class="modal-body pt-2">
                    <div class="pr-0 border-b border-gray-200 dark:border-dark-5">
                        <div class="p-0 overflow-x-auto overflow-y-hidden">
                            <ul class="nav nav-link-tabs text-center" role="tablist">
                                <li id="Overview-tab" class="nav-item flex-1" role="presentation">
                                    <a data-tw-toggle="pill" data-tw-target="#Overview" href="javascript:;"
                                        class="nav-link w-full py-2 active whitespace-nowrap" role="tab"
                                        aria-controls="Overview" aria-selected="true">Overview</a>
                                </li>
                                <li id="Notes-tab" class="nav-item flex-1" role="presentation">
                                    <a data-tw-toggle="pill" data-tw-target="#Notes" href="javascript:;"
                                        class="nav-link w-full py-2 whitespace-nowrap" role="tab" aria-controls="Notes"
                                        aria-selected="false">Notes</a>
                                </li>
                                <li id="Attachments-tab" class="nav-item flex-1" role="presentation">
                                    <a data-tw-toggle="pill" data-tw-target="#Attachments" href="javascript:;"
                                        class="nav-link w-full py-2 whitespace-nowrap" role="tab"
                                        aria-controls="Attachments" aria-selected="false">Attachments</a>
                                </li>
                                @if (!Auth::user()->isSubscriber())
                                    <li id="KYC-documents-tab" class="nav-item flex-1" role="presentation">
                                        <a data-tw-toggle="pill" data-tw-target="#KYCdocuments" href="javascript:;"
                                            class="nav-link w-full py-2 whitespace-nowrap" role="tab"
                                            aria-controls="KYCdocuments" aria-selected="false">KYC Documents</a>
                                    </li>
                                    <li id="CurrencycloudPayout-tab" class="nav-item flex-1" role="presentation">
                                        <a data-tw-toggle="pill" data-tw-target="#CurrencycloudPayout" href="javascript:;"
                                            class="nav-link w-full py-2 whitespace-nowrap" role="tab"
                                            aria-controls="CurrencycloudPayout" aria-selected="false">CC Payout</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content py-3">

                        <div id="Overview" class="tab-pane active " role="tabpanel" aria-labelledby="Overview-tab">
                            @livewire('transaction-detail-component')
                        </div>

                        <div id="Notes" class="tab-pane" role="tabpanel" aria-labelledby="Notes-tab">
                            @livewire('transaction-log-component')
                        </div>

                        <div id="Attachments" class="tab-pane" role="tabpanel" aria-labelledby="Attachments-tab">
                            @livewire('transaction-attachment-component')
                        </div>

                        <div id="KYCdocuments" class="tab-pane" role="tabpanel" aria-labelledby="KYC-documents-tab">
                            @livewire('transaction-kycdetails-component')
                        </div>

                        <div id="CurrencycloudPayout" class="tab-pane" role="tabpanel"
                            aria-labelledby="CurrencycloudPayout-tab">
                            @livewire('currency-cloud-payout-component')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="superlarge-slide-over-size-preview" class="modal modal-slide-over" tabindex="-1" aria-hidden="true"
        style="padding-left: 0px;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h2 class="font-medium text-base mr-auto">
                        Transaction Activity
                    </h2>
                </div>
                <div class="modal-body">
                    @livewire('transaction-track-component')

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
@push('scripts')
    <script>
        $('#create_pdf').click(function() {
            var currentPosition = document.getElementById("Overview").scrollTop;
            var w = document.getElementById("Overview").offsetWidth;
            var h = document.getElementById("Overview").offsetHeight;
            document.getElementById("Overview").style.height = "800";

            html2canvas(document.getElementById("Overview"), {
                useCORS: true,
                background: '#fff',
                dpi: 300, // Set to 300 DPI
                scale: 3, // Adjusts your resolution
                onrendered: function(canvas) {
                    var img = canvas.toDataURL("image/png", 1);
                    var doc = new jsPDF('L', 'px', [w, h]);
                    doc.addImage(img, 'PNG', 0, 0, w, h);
                    doc.save('transaction-invoice.pdf');
                }
            });

            document.getElementById("Overview").scrollTop = currentPosition;
        });

        window.addEventListener('show-transaction-detail-modal', event => {
            const myModal = tailwind.Modal.getInstance(document.querySelector("#subscription-modal"));
            myModal.show();
        });

        window.addEventListener('show-transaction-track', event => {
            const myModal = tailwind.Modal.getInstance(document.querySelector(
                "#superlarge-slide-over-size-preview"));
            myModal.show();
        });
    </script>
@endpush
