@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
    <div class="px-5 sm:px-10 mt-10 pt-10 border-t border-gray-200">
        <div class="intro-y col-span-12 lg:col-span-12">
            <form method="POST" action="{{ route('dashboard.international-transfer.money-transfer.store') }}">
            @csrf
            <div class="intro-y mt-0 p-3">
                <div class="grid grid-cols-12 rounded-lg m-auto p-0 ">
                    <div class="col-span-12 md:col-span-8 mony-transfer m-auto">
                        <h3 class="text-2x1 font-black mb-4">How Much Would you like to transfer?</h3>
                        @livewire('initial-process',['countries' => $countries, 'defaultCountry' => $defaultCountry])

                        {{-- <p class="py-3">
                            You could save up to <strong>20.59 GBP</strong> vs tha average bank
                            should arrive in <strong>4 hours</strong>
                        </p> --}}

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
    </script>
@endpush
