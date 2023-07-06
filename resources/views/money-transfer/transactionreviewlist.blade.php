@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="flex items-center p-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Compliance Alerts
                    </h2>
                </div>

                <div class="p-5">
                    <div class="grid grid-cols-12  gap-3">
                        <div class="col-span-12 lg:col-span-12 xxl:col-span-12 mt-0">
                            <div class="grid grid-cols-12 gap-3">
                                <!-- BEGIN: -->
                                <div class="intro-y col-span-12 lg:col-span-12 xxl:col-span-12 p-0">
                                    <div id="1" class="tab-pane grid grid-cols-12 gap-3 pt-0" role="tabpanel"
                                        aria-labelledby="1-tab">
                                        <div class="active col-span-12 mt-0 w-full" role="tabpanel" id="k-wallet"
                                            aria-labelledby="k-wallet-tab">
                                            <div class="Livewire-datatable-modal pb-3">
                                                <livewire:data-table model='Kanexy\InternationalTransfer\Contracts\MoneyTransferReviewList'
                                                    params="" type='money-transfer'/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <div class="p-0">
                            <ul class="nav nav-link-tabs text-center" role="tablist">
                                <li id="Overview-tab" class="nav-item flex-1" role="presentation">
                                    <a data-tw-toggle="pill" data-tw-target="#Overview" href="javascript:;"
                                        class="nav-link w-full py-2 active" role="tab" aria-controls="Overview"
                                        aria-selected="true">Overview</a>
                                </li>
                                <li id="Notes-tab" class="nav-item flex-1" role="presentation">
                                    <a data-tw-toggle="pill" data-tw-target="#Notes" href="javascript:;"
                                        class="nav-link w-full py-2" role="tab" aria-controls="Notes"
                                        aria-selected="false">Notes</a>
                                </li>
                                <li id="Attachments-tab" class="nav-item flex-1" role="presentation">
                                    <a data-tw-toggle="pill" data-tw-target="#Attachments" href="javascript:;"
                                        class="nav-link w-full py-2" role="tab" aria-controls="Attachments"
                                        aria-selected="false">Attachments</a>
                                </li>
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
