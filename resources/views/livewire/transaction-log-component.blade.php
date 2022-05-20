<div>
    <div class="p-5">
            @if ($logSent == true)
                <h4 class="text-theme-9 mb-2">Message send successfully</h4>
            @endif
            <div class="grid grid-cols-12 md:gap-10 mt-0">
                <div class="col-span-12 md:col-span-6 form-inline mt-2" style="align-items: inherit;">
                    <label class="form-label sm:w-20">Description <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                       <textarea wire:model.defer="description" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 "x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">
                <div class="form-inline mt-2" >
                    <label class="form-label sm:w-20">Attachment</label>
                    <div class="sm:w-5/6">
                        <input id="attachment" wire:model="attachment" name="attachment" type="file" class="form-control">
                    </div>

                </div>
                <div x-show="isUploading">
                    <progress max="100" x-bind:value="progress"></progress>
                    Uploading...
                </div>
                </div>

            </div>
            <div class="text-right mt-5" >
                <button type="button"   wire:click="transactionLogSubmit({{ $transaction }})" class="btn btn-sm btn-primary w-24 mr-1" >Save</button>
            </div>
            <div class="flex mt-5">
            </div>
        </form>
    </div>

        <!-- BEGIN: Recent Activities -->
    <div class="grid grid-cols-12 gap-0"  style="max-height:350px;overflow-y:auto;">
        <div class="col-span-12 md:col-span-12 xl:col-span-12 xxl:col-span-12 pt-1">
            <div class="intro-x flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">

                </h2>
                <a href="" class="ml-auto text-theme-1 dark:text-theme-10 truncate"></a>
            </div>
            @isset ($logs)
                @foreach ($logs as $log)
                    <div class="report-timeline mb-0 relative">
                        <div class="intro-x relative flex items-center pb-3">
                            <div class="report-timeline__image">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="" class="rounded-full" src="{{asset("dist/images/user.png") }}">
                                </div>
                            </div>
                            <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                                <div class="flex items-center">

                                    <div class="text-xs text-gray-500 ml-auto">  {{ $log->user->getFullName() }}, {{ date('d-m-Y H:i:s',strtotime($log->updated_at)) }}</div>
                                </div>
                                <div class="text-gray-600 mt-1"><p>{!! $log->text !!}</p>@isset($log->meta['attachment'])
                                    <a target="_blank" href="{{ \Illuminate\Support\Facades\Storage::disk('azure')->url($log->meta['attachment']) }}"> <x-feathericon-file height="25"/></a>
                                    @endif</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset


        </div>
    </div>
    <!-- END: Recent Activities -->
</div>
