<div>
    <div class="py-5">
            @if ($logSent == true)
                <h4 class="alert-success mb-2 text-white mb-2 p-2 rounded-md">Message send successfully</h4>
            @endif
            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-8 mt-0">
                <div class="col-span-12 md:col-span-12 form-inline mt-2" style="align-items: inherit;">
                    <label class="form-label sm:w-28">Description <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                       <textarea wire:model.defer="description" class="form-control" required></textarea>
                       @error('description')
                       <span class="block text-theme-6 mt-2">{{ $message }}</span>
                       @enderror
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
            @if (!isset($logs))
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

                                    <div class="text-xs text-gray-500 ml-auto">  {{ $log?->user?->getFullName() }}, {{ date('D d/m/Y H:i',strtotime($log->updated_at)) }}</div>
                                </div>
                                <div class="text-gray-600 mt-1"><p>{!! $log->text !!}</p></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif


        </div>
    </div>
    <!-- END: Recent Activities -->
</div>
