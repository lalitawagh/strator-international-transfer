<div>
    <div class="p-5 mt-5">
            <div class="md:flex mt-2">
                <div class="w-full px-4">
                    <div class="form-inline mt-2">
                        <div class="form w-full ml-5">

                            <textarea class="editor"  id="text" wire:model.defer="description"></textarea>
                            <button type="button" wire:click="transactionLogSubmit({{ $transaction }})" class="btn btn-sm btn-primary w-24 mr-1" style="margin-left: 18px; margin-top: 12px;
                            ">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex mt-5">
            </div>
        </form>
    </div>

        <!-- BEGIN: Recent Activities -->
    <div class="grid grid-cols-12 gap-0" id="refreshLogs">
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
                                    <div class="font-medium">{{ $log->user->getFullName() }}</div>
                                    <div class="text-xs text-gray-500 ml-auto">{{ $log->updated_at }}</div>
                                </div>
                                <div class="text-gray-600 mt-1">{!! $log->text !!}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset


        </div>
    </div>
    <!-- END: Recent Activities -->
</div>
