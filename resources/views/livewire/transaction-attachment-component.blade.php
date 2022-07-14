<div>
    <div class="py-5">
        <form enctype="multipart/form-data">
            @if ($logSent == true)
                <h4 class="alert-success mb-2 text-white mb-2 p-2 rounded-md">Attachment updated successfully</h4>
            @endif
            <div class="grid grid-cols-12 md:gap-10 mt-0">

                <div class="col-span-12 md:col-span-6 "x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">
                <div class="form-inline mt-2" >
                    <label class="form-label sm:w-20">Attachment</label>
                    <div class="sm:w-5/6">
                        <input id="attachment" wire:model="attachment" name="attachment" type="file" class="form-control" multiple>
                        @error('attachment.0')
                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div x-show="isUploading">
                    <progress max="100" x-bind:value="progress"></progress>
                    Uploading...
                </div>
                </div>


            </div>
            <div class="text-right mt-5" >
                <button type="button"   wire:click="transactionAttachmentSubmit({{ $transaction?->id }})" class="btn btn-sm btn-primary w-24 mr-1" >Save</button>
            </div>
            <div class="flex mt-5">
            </div>
        </form>
    </div>
        <!-- BEGIN: Recent Activities -->
        <div class="grid grid-cols-12 gap-4 mt-0"  style="max-height:350px;overflow-y:auto;">
            @if (!isset($mediaItems))
                <div class="mt-5">
                    <svg width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="rgb(45, 55, 72)"
                        class="w-8 h-8 block mx-auto">
                        <g fill="none" fill-rule="evenodd">
                            <g transform="translate(1 1)" stroke-width="4">
                                <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle>

                                <path d="M36 18c0-9.94-8.06-18-18-18">
                                    <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18"
                                        dur="1s" repeatCount="indefinite"></animateTransform>
                                </path>
                            </g>
                        </g>
                    </svg>
                </div>
            @else
                @foreach ($mediaItems as $mediaItem)
                    <div class="col-span-12 lg:col-span-3 xxl:col-span-3 mt-5 px-3 pb-5">
                        <div class="h-40 min-h-full relative image-fit cursor-pointer zoom-in mx-auto selfievideo">
                        <img alt="" class="rounded-md" src="{{ $mediaItem->getUrl() }}">
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
        <!-- END: Recent Activities -->
</div>
