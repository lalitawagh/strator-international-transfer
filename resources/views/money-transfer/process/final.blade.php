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
                            @if ($transaction->status == 'accepted')
                                <div class="pb-20 text-center">
                                    <i data-lucide="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
                                    <div class="text-3xl mt-5">Money Transfer Successful</div>
                                </div>
                            @else
                                <div class="pb-20 text-center">
                                    <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i>
                                    <div class="text-3xl mt-5">Threshold Exceeded</div>
                                    <div class="text-slate-500 mt-2">Your transaction is in under review.</div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.location.href =
                    '{{ route('dashboard.international-transfer.money-transfer.index', ['filter' => ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]]) }}';
            }, 10000);
        }
    </script>
@endpush
