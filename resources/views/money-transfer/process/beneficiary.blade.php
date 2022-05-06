@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('money-transfer-content')
    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
        <div class="intro-y col-span-12 lg:col-span-12">
            <h3 class="text-2xl font-black mb-4 text-center py-4">Select or create beneficiary</h3>
            <!-- BEGIN: Horizontal Form -->
            <div class="grid rounded-lg w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5">
                <div
                    class="font-medium text-base col-span-12 sm:col-span-12 xxl:col-span-12 py-3">
                    New Beneficiary</div>
                <a data-toggle="modal" data-target="#myself-modal"
                    class="border-2 border-theme-1 dark:border-theme-1 col-span-12 sm:col-span-4 xxl:col-span-3 p-5 cursor-pointer zoom-in text-center border-l border border-gray-200 dark:border-dark-5 rounded">
                    <div class="font-medium text-base"><i data-feather="user" class="block w-12 h-12 mb-2 mx-auto"></i></div>
                    <div class="font-medium text-center text-base mt-3">Myself</div>
                </a>
                <a data-toggle="modal" data-target="#someone-else-modal"
                    class="col-span-12 sm:col-span-4 xxl:col-span-3 p-5 cursor-pointer zoom-in text-center border-l border border-gray-200 dark:border-dark-5 rounded">
                    <div class="font-medium text-base text-base"><i data-feather="users" class="block w-12 h-12 mb-2 mx-auto"></i></div>
                    <div class="font-medium text-center text-base mt-3">Someone else</div>
                </a>
                <a data-toggle="modal" data-target="#business-modal"
                    class="col-span-12 sm:col-span-4 xxl:col-span-3 p-5 cursor-pointer zoom-in text-center border-l border border-gray-200 dark:border-dark-5 rounded">
                    <div class="font-medium text-base"><i data-feather="home"  class="block w-12 h-12 mb-2 mx-auto"></i></div>
                    <div class="font-medium text-center text-base mt-3">Business or charity
                    </div>
                </a>
            </div>

            @livewire('existing-beneficiary',['workspace' => $workspace])


        </div>
        <div
            class="text-right mt-5 py-4  w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5 mt-5 pt-3 text-right mt-5  py-4">
            <button class="btn btn-secondary w-24">Previous</button>
            <button class="btn btn-primary w-24 ml-2" >Continue</button>
        </div>
    </div>

    @include('international-transfer::money-transfer.process.beneficiary-modal', ['beneficiaryType' => 'myself'])
    @include('international-transfer::money-transfer.process.beneficiary-modal', ['beneficiaryType' => 'someone-else'])
    @include('international-transfer::money-transfer.process.beneficiary-modal', ['beneficiaryType' => 'business'])

    <!-- BEGIN: OTP Modal -->
    <div id="otp-modal" class="modal modal-slide-over otp-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h2 class="font-medium text-base mr-auto">
                        OTP Verification
                    </h2>
                    <div class="items-center justify-center mt-0">
                        {{-- <a data-toggle="modal" data-target="#review-transfer"
                            class="btn-sm bg-indigo-600 btn-primary text-white font-bold py-3 px-6 rounded">Confirm</a> --}}
                    </div>
                </div>
                @livewire('otp-verification',['countries' => $countries, 'defaultCountry' => $defaultCountry, 'user' => $user, 'account' => $account, 'workspace' => $workspace])
            </div>
        </div>
    </div>
    <!-- END: OTP Modal -->


@endsection

@push('scripts')
    <script>
        window.addEventListener('showOtpModel', event => {
            cash("#"+event.detail.modalType+"-modal").modal("hide");
            cash("#otp-modal").modal("show");
        });

        window.addEventListener('confirmBeneficiary', event => {
            cash("#confirm-beneficiary-modal-preview").modal("show");
        });

        function getFlagImg(the,type) {
            var img = $('option:selected', the).attr('data-source');
            $('#countryWithPhoneFlagImgTransfer'+type).html('<img src="' + img + '">');
        }

        function getFlagImgLandline(the,type) {
            var img = $('option:selected', the).attr('data-source');
            $('#countryWithLandlineFlagImgTransfer'+type).html('<img src="' + img + '">');
        }
    </script>
@endpush
