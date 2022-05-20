@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
    <div class="px-5 mt-3 sm:px-10 sm:mt-10 sm:pt-10 border-t border-gray-200">
        <div class="intro-y col-span-12 lg:col-span-12">
            <form method="POST" action="{{ route('dashboard.international-transfer.money-transfer.store') }}">
            @csrf
            <input type="hidden" name="workspace_id" value="{{ $workspace->id }}">
            <div class="intro-y mt-0 p-3">
                <div class="grid grid-cols-12 rounded-lg m-auto p-0 ">
                    <div class="col-span-12 md:col-span-8 mony-transfer m-auto">
                        <h3 class="text-lg font-medium mb-4">Enter the amount to Transfer</h3>
                        @livewire('initial-process',['countries' => $countries, 'defaultCountry' => $defaultCountry])

                        {{-- <p class="py-3">
                            You could save up to <strong>20.59 GBP</strong> vs tha average bank
                            should arrive in <strong>4 hours</strong>
                        </p> --}}
                        @error('recipient_amount')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror

                        <div class="text-right mt-5 py-4">
                            <a data-toggle="modal" data-target="#large-slide-over-size-preview"
                                class="btn btn-secondary">Compare Price</a>

                        <button class="btn btn-primary w-24 ml-2" >Continue</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('disabledSelectedCountry', event => {
            $('#tabcuntery-selection2 option').attr("disabled", false);
            $('#tabcuntery-selection2 option[value="'+ event.detail.currency +'"]').attr("disabled", true);
        });

        function preventNonNumericalInput(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
@endpush
