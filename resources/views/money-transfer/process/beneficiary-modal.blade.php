<!-- BEGIN: Myself Modal -->
<div id="{{ $beneficiaryType }}-modal" class="modal modal-slide-over {{ $beneficiaryType }}-modal" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-xl ihphone-scroll-height">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h2 class="font-medium text-base mr-auto">
                    Send to {{ trans('international-transfer::configuration.' . $beneficiaryType) }}
                </h2>
                <div class="items-center justify-center mt-0">
                    {{-- <a data-tw-toggle="modal" data-tw-target="#review-transfer"
                        class="btn-sm bg-indigo-600 btn-primary text-white font-bold py-3 px-6 rounded">Confirm</a> --}}
                </div>
            </div>
            <div class="modal-body">
                @livewire('myself-beneficiary', ['countries' => $countries, 'defaultCountry' => $defaultCountry, 'user' => $user, 'workspace' => $workspace, 'beneficiaryType' => $beneficiaryType])
            </div>
        </div>
    </div>
</div>
<!-- END: Myself Modal -->
