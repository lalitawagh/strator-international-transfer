<div>
    <div class="intro-y box col-span-12 lg:col-span-12">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div class="p-5 overflow-y-scroll">
            @foreach ($balanceCurrency as $country)
                <a wire:click="addCurrency({{ $country->id }})">
                    {{-- <input type="hidden" value="{{ $country?->id }}" name="balance_currency"> --}}
                    <div class="relative flex items-center border-b pb-3">
                        <div class="w-12 h-12 pt-1 flex-none image-fit">
                            <img class="rounded-full" src="{{ $country->flag }}">
                        </div>
                        <div class="ml-4 mr-auto">
                            <div class="text-slate-500 mr-5 sm:mr-5">{{ $country->currency }} ({{ $country->code }}) {{ $country->name }}</div>
                        </div>
                        <div class="font-medium text-slate-600 dark:text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right"
                                class="lucide lucide-chevron-right w-6 h-6" data-lucide="chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
            {{-- <div class="relative flex items-center border-b pb-3 mt-2">
                <div class="w-12 h-12 flex-none image-fit">
                    <img alt="Midone - HTML Admin Template" class="rounded-full"
                        src="dist/images/profile-2.jpg">
                </div>
                <div class="ml-4 mr-auto">
                    <a href="" class="font-medium">977,725.09 INR</a>
                    <div class="text-slate-500 mr-5 sm:mr-5">Indian Rupee</div>
                </div>
                <div class="font-medium text-slate-600 dark:text-slate-500"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right"
                        class="lucide lucide-chevron-right w-6 h-6" data-lucide="chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg></div>
            </div>
            <div class="relative flex items-center border-b pb-3 mt-2">
                <div class="w-12 h-12 flex-none image-fit">
                    <img alt="Midone - HTML Admin Template" class="rounded-full"
                        src="dist/images/profile-9.jpg">
                </div>
                <div class="ml-4 mr-auto">
                    <a href="" class="font-medium">416,673.13 GBP</a>
                    <div class="text-slate-500 mr-5 sm:mr-5">British Pound</div>
                </div>
                <div class="font-medium text-slate-600 dark:text-slate-500"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right"
                        class="lucide lucide-chevron-right w-6 h-6" data-lucide="chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg></div>
            </div> --}}
        </div>
    </div>
</div>
