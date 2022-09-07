@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
    <div class="px-5 sm:px-5 mt-3 sm:pt-3 lg:mt-10 lg:pt-10 border-t border-gray-200">
        <form method="POST"
            action="{{ route('dashboard.international-transfer.money-transfer.beneficiaryStore', ['filter' => ['workspace_id' => $workspace->id]]) }}">
            @csrf
            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Horizontal Form -->
                <div class="rounded-lg w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5">
                    <h3 class="text-lg font-medium mb-4 sm:mb-2 text-left py-2">Select or Create Beneficiary</h3>
                    <div class="font-medium text-base col-span-12 sm:col-span-12 xxl:col-span-12 py-2"> New Beneficiary</div>
                    <div class="grid grid-cols-12 gap-6">
                        <a data-tw-toggle="modal" data-tw-target="#myself-modal"
                            class="col-span-12 sm:col-span-4 md:col-span-4 lg:col-span-4 xxl:col-span-4 p-5 cursor-pointer zoom-in text-center border-l border border-gray-200 dark:border-dark-5 rounded">
                            <div class="font-medium text-base">
                                <img alt="" class="m-auto" src="{{ asset('dist/images/self-icon.png') }}">
                            </div>
                            <div class="font-medium text-center text-base mt-3 break-words">Self</div>
                        </a>
                        <a data-tw-toggle="modal" data-tw-target="#someone-else-modal"
                            class="col-span-12 sm:col-span-4 md:col-span-4 lg:col-span-4 xxl:col-span-4 p-5 cursor-pointer zoom-in text-center border-l border border-gray-200 dark:border-dark-5 rounded">
                            <div class="font-medium text-base text-base">
                                <img alt="" class="m-auto" src="{{ asset('dist/images/someone-els-icon.png') }}">
                            </div>
                            <div class="font-medium text-center text-base mt-3 break-words">Another Person</div>
                        </a>
                        <a data-tw-toggle="modal" data-tw-target="#business-modal"
                            class="col-span-12 sm:col-span-4 md:col-span-4 lg:col-span-4 xxl:col-span-4 p-5 cursor-pointer zoom-in text-center border-l border border-gray-200 dark:border-dark-5 rounded">
                            <div class="font-medium text-base">
                                <img alt="" class="m-auto" src="{{ asset('dist/images/business-c-icon.png') }}">
                            </div>
                            <div class="font-medium text-center text-base mt-3 break-words">Business/Welfare
                            </div>
                        </a>
                    </div>
                </div>

                @livewire('existing-beneficiary', ['workspace' => $workspace])
                <div class="grid rounded-lg w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5 mt-5 pt-3">
                    @error('beneficiary')
                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="text-right mt-5 py-4  w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5 mt-5 pt-3 text-right mt-5  py-4">
                <a href="{{ route('dashboard.international-transfer.money-transfer.create', ['filter' => ['workspace_id' => $workspace->id]]) }}"
                    class="btn btn-secondary w-24">Previous</a>
                <button class="btn btn-primary w-24 ml-2">Continue</button>
            </div>
        </form>
    </div>

    @include('international-transfer::money-transfer.process.beneficiary-modal', [
        'beneficiaryType' => 'myself',
    ])
    @include('international-transfer::money-transfer.process.beneficiary-modal', [
        'beneficiaryType' => 'someone-else',
    ])
    @include('international-transfer::money-transfer.process.beneficiary-modal', [
        'beneficiaryType' => 'business',
    ])

    <!-- BEGIN: OTP Modal -->
    <div id="otp-modal" class="modal modal-slide-over otp-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h2 class="font-medium text-base mr-auto">
                        OTP Verification
                    </h2>
                    <div class="items-center justify-center mt-0">
                        {{-- <a data-tw-toggle="modal" data-tw-target="#review-transfer"
                            class="btn-sm bg-indigo-600 btn-primary text-white font-bold py-3 px-6 rounded">Confirm</a> --}}
                    </div>
                </div>
                @livewire('otp-verification-component', ['countries' => $countries, 'defaultCountry' => $defaultCountry, 'user' => $user, 'account' => $account, 'workspace' => $workspace])
            </div>
        </div>
    </div>
    <!-- END: OTP Modal -->
@endsection

@push('scripts')
    <script>
        window.addEventListener('showOtpModel', event => {
            const mySlideOver = tailwind.Modal.getOrCreateInstance(document.querySelector("#" + event.detail
                .modalType + "-modal"));
            mySlideOver.hide();

            const showModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#otp-modal"));
            showModal.show();
        });

        window.addEventListener('confirmBeneficiary', event => {
            const showModal = tailwind.Modal.getOrCreateInstance(document.querySelector(
                "#confirm-beneficiary-modal-preview"));
            showModal.show();
        });

        function getFlagImg(the, type) {
            var img = $('option:selected', the).attr('data-source');
            $('#countryWithPhoneFlagImgTransfer' + type).html('<img src="' + img + '">');
        }

        function getFlagImgLandline(the, type) {
            var img = $('option:selected', the).attr('data-source');
            $('#countryWithLandlineFlagImgTransfer' + type).html('<img src="' + img + '">');
        }
    </script>
@endpush
