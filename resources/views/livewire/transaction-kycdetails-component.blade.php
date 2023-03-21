<div>
    <div class="intro-y col-span-12 lg:col-span-12 overflow-x-auto ">
        <div class="intro-y box mt-0">
            <div class="preview p-5" id="personalInformation">
                <div class="form-inline mt-2 grid grid-cols-12 gap-2">

                    @isset($documents)

                        @foreach ($documents as $document)
                            @if (
                                $document->type == 'id_proof1' ||
                                    $document->type == 'id_proof2' ||
                                    $document->type == 'address_proof' ||
                                    $document->type == 'verification_image')
                                @isset($yotiLog)
                                    @if ($yotiLog->value['id_proof'] == 'PASSPORT' && $document->type == 'id_proof2')
                                    @else
                                        <div class="col-span-12 sm:col-span-6 lg:col-span-4 xxl:col-span-3">
                                            <div
                                                class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                                                <div
                                                    class="flex items-center px-3 py-2 sm:py-2 border-b border-gray-200 dark:border-dark-5">
                                                    <h2 class="font-medium text-base mr-auto">
                                                        @if ($document->type == 'id_proof1')
                                                            Identity Proof Front
                                                        @elseif ($document->type == 'id_proof2' && $yotiLog->value['id_proof'] != 'PASSPORT')
                                                            Identity Proof Back
                                                        @elseif ($document->type == 'address_proof')
                                                            Address Proof
                                                        @elseif ($document->type == 'verification_image')
                                                            Liveness Capture
                                                        @endif
                                                    </h2>

                                                </div>
                                                @php
                                                    $extension = substr($document->media, strpos($document->media, '.') + 1);
                                                    
                                                @endphp
                                                <div
                                                    class="h-40 min-h-full relative image-fit cursor-pointer zoom-in mx-auto selfievideo">

                                                    @if ($extension == 'application/octet-stream')
                                                        <img class="rounded-md proof-default" alt=""
                                                            src="{{ asset('img/pdf.png') }}">
                                                    @else
                                                        <img class="rounded-md proof-default" alt=""
                                                            src="{{ \Illuminate\Support\Facades\Storage::disk('azure')->temporaryUrl($document->media, now()->addMinutes(5)) }}">
                                                    @endif

                                                    <div
                                                        class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-6 right-0 top-0 -mr-2 -mt-2">
                                                        <i data-lucide="x" class="w-4 h-4 mr-0"></i>
                                                    </div>

                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                    @endif
                                @endisset
                            @endif
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div class="py-5">
        @if ($success_status == true)
            <h4 class="text-success font-weight-bold mb-2 mt-5">{{ $message }}</h4>
        @endif
        <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-8 mt-0">
            <div class="col-span-12 md:col-span-12 form-inline mt-1" style="align-items: inherit;">
                <div class="sm:w-5/6">
                    <label for="flag" class="form-label sm:w-28">Flag<span class="text-theme-6"> *</span></label>
                    <select id="flag" wire:change="handleflagChange($event.target.value)" data-search="true"
                        class="form-select mt-2 sm:mr-2 @error('flag') border-theme-6 @enderror" autocomplete="off">
                        <option value="" selected>Select Flag</option>
                        @foreach (Kanexy\InternationalTransfer\Enums\FlagStatus::FLAG_STATUS as $index => $typeName)
                            <option wire:key="{{ $index }}" value="{{ $index }}"
                                {{ $flag == $index ? 'selected' : '' }}>{{ $typeName }}
                            </option>
                        @endforeach
                    </select>
                    @error('flag')
                        <span class="block text-theme-6 mt-2 mb-5">{{ $message }}</span>
                    @enderror
                </div>
                <div class="sm:w-5/6 mt-5">
                    <button id="updateFlag" type="button" wire:loading.remove class="btn btn-primary w-34 ml-2 mt-5"
                        wire:click="updateFlag">Update Flag</button>
                    <button wire:loading wire:target="updateFlag" type="button" class="btn btn-primary w-30 ml-2 mt-5">
                        Generating...
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
