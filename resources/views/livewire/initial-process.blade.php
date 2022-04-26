<div>
<div class="mb-4 relative">
    <input wire:change="changeAmount($event.target.value)" class="input border border-gray-400 appearance-none rounded w-full px-3 py-3 pt-5 pb-2 focus focus:border-indigo-600 focus:outline-none active:outline-none active:border-indigo-600" type="text" autofocus>
    <label class="label absolute mb-0 -mt-0 pt-0 pl-3 leading-tighter text-gray-400 text-base mt-0 cursor-text">You Send</label>

    <div id="input-group-email" class="input-group-text form-inline cuntery-in flex gap-2">
        <span id="fromCountry">@foreach ($countries as $country)
            @isset($currency_from)
                @if ($country->currency == $currency_from)
                    <img src="{{ $country->flag }}">
                @endif
            @else
                @if ($country->id == $defaultCountry->id)
                    <img src="{{ $country->flag }}">
                @endif
            @endisset
        @endforeach</span>
        <select id='tabcuntery-selection1' style='width: 105px;' wire:change="changeFromCurrency($event.target.value)"  class="" name="currency_code_from">
            @foreach ($countries as $country)
                <option data-source="{{ $country->flag }}" value="{{ $country->currency }}"
                    @isset($currency_from)
                        @if ($country->currency == $currency_from)
                            selected
                        @endif
                    @else
                        @if ($country->id == $defaultCountry->id)
                            selected
                        @endif
                    @endisset>
                    {{ $country->currency }}
                </option>
            @endforeach

        </select>
    </div>
</div>

<div class="mb-4 relative">
    <ul class="sequence sequence-top sequence-bottom tw-calculator-breakdown tw-calculator-breakdown--detailed sequence-inverse tw-calculator-breakdown--inverse">


        <li>
            <span class="sequence-icon tw-calculator-breakdown__icon">–</span>
            <span class="tw-calculator-breakdown-item__left"><strong>4.35  GBP</strong></span>
            <span class="tw-calculator-breakdown-item__right">
                <span class="m-r-1" data-tracking-id="calculator-payment-select">
                    <div class="tw-select btn-group dropdown">
                        <div class="dropdown-toggle notification cursor-pointer" role="button"
                            aria-expanded="false">
                            <button class="btn btn-sm btn-secondary mr-4 mb-0">
                                Fast & Easy Transfer
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        <div class="notification-content pt-2 dropdown-menu">
                            <div class="notification-content__box dropdown-menu__content box dark:bg-dark-6">
                                <div class="cursor-pointer relative items-center cursor-pointer relative items-center px-3 py-1 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md  ">
                                    <div class="ml-0 overflow-hidden">
                                        <div class="flex items-center">
                                            <h4 href="javascript:;" class="font-medium truncate mr-5">
                                                Fast % easy transfer -4.39 GBP fee</h4>
                                            <div class="text-xs text-gray-500 ml-auto whitespace-nowrap text-right float-right">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="w-full truncate text-gray-600 mt-0.5">
                                            Send money from your debit or credit card</div>
                                    </div>
                                </div>
                                <hr class="pb-3 mt-2">
                                <div class="cursor-pointer relative items-center cursor-pointer relative items-center px-3 py-1 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md  ">
                                    <div class="ml-0 overflow-hidden">
                                        <div class="flex items-center">
                                            <h4 href="javascript:;" class="font-medium truncate mr-5">
                                                Fast % easy transfer -4.39 GBP fee</h4>
                                            <div
                                                class="text-xs text-gray-500 ml-auto whitespace-nowrap text-right float-right">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="w-full truncate text-gray-600 mt-0.5">
                                            Send money from your debit or credit card
                                        </div>
                                    </div>
                                </div>
                                <hr class="pb-3 mt-2">
                                <div class="cursor-pointer relative items-center cursor-pointer relative items-center px-3 py-1 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md  ">
                                    <div class="ml-0 overflow-hidden">
                                        <div class="flex items-center">
                                            <h4 href="javascript:;" class="font-medium truncate mr-5">
                                                Fast % easy transfer -4.39 GBP fee</h4>
                                            <div class="text-xs text-gray-500 ml-auto whitespace-nowrap text-right float-right">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="w-full truncate text-gray-600 mt-0.5">
                                            Send money from your debitor credit card
                                        </div>
                                    </div>
                                </div>
                                <hr class="pb-3 mt-2">
                                <div
                                    class="cursor-pointer relative items-center cursor-pointer relative items-center px-3 py-1 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md  ">
                                    <div class="ml-0 overflow-hidden">
                                        <div class="flex items-center">
                                            <h4 href="javascript:;" class="font-medium truncate mr-5">
                                                Fast % easy transfer -4.39 GBP fee</h4>
                                            <div
                                                class="text-xs text-gray-500 ml-auto whitespace-nowrap text-right float-right">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="w-full truncate text-gray-600 mt-0.5">
                                            Send money from your debit or credit card
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </span>
                <span style="text-transform:none">Fees</span>
            </span>

        </li>
        <li><span class="sequence-icon tw-calculator-breakdown__icon">=</span>
            <span class="tw-calculator-breakdown-item__left">993.33 INR</span>
            <span class="tw-calculator-breakdown-item__right">Amount we'll convert</span>
        </li>
        <li>
            <span class="sequence-icon tw-calculator-breakdown__icon">x</span>
            <span class="tw-calculator-breakdown-item__left">{{ $guaranteed_rate }}</span>
            <span class="px-3 border-2 cursor-pointer border-dashed dark:border-dark-5 rounded-md tw-calculator-breakdown-item__right tooltip"
                data-theme="light" data-tooltip-content="#custom-content-tooltip" data-trigger="click"
                title="This is awesome tooltip example!">
                Guaranteed Rate
            </span>

            <!-- BEGIN: Custom Tooltip Content -->
            <div class="tooltip-content">
                <div id="custom-content-tooltip" class="relative flex items-center py-1">
                    <div class="ml-4 mr-auto">
                        <div class="text-gray-600">You'll get this rate
                            as long as we receive your 1,000 GBP within
                            the Next 2 hours.</div>
                        <a href="" class="btn btn-secondary btn-sm block w-40 mx-auto mt-3">Learn More</a>
                    </div>
                </div>
            </div>
            <!-- END: Custom Tooltip Content -->

        </li>
    </ul>
</div>
<div class="mb-4 relative">
    <input wire:model="recipient_amount" class="input border border-gray-400 appearance-none rounded w-full px-3 py-3 pt-5 pb-2 focus focus:border-indigo-600 focus:outline-none active:outline-none active:border-indigo-600" type="text" autofocus>
    <label class="label absolute mb-0 -mt-0 pt-0 pl-3 leading-tighter text-gray-400 text-base mt-0 cursor-text">Recipient Gets</label>

    <div id="input-group-email" class="input-group-text form-inline cuntery-in flex gap-2">
        <span id="toCountry">@foreach ($countries as $country)
            @isset($currency_to)
                @if ($country->currency == $currency_to)
                    <img src="{{ $country->flag }}">
                @endif
            @else
                @if ($country->id == $defaultCountry->id)
                    <img src="{{ $country->flag }}">
                @endif
            @endisset
        @endforeach</span>
        <select id='tabcuntery-selection2' style='width: 105px;'  wire:change="changeToCurrency($event.target.value)"  class="" name="currency_code_to">
            @foreach ($countries as $country)
                <option data-source="{{ $country->flag }}" value="{{ $country->currency }}"
                    @isset($currency_to)
                        @if ($country->currency == $currency_to)
                            selected
                        @endif
                    @else
                        @if ($country->id == $defaultCountry->id)
                            selected
                        @endif
                    @endisset>
                    {{ $country->currency }}
                </option>
            @endforeach

        </select>
    </div>
    <span class="lock-amount tooltip" data-theme="light" data-tooltip-content="#custom-content-tooltip1"
        data-trigger="click" title="This is awesome tooltip example!">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
    </span>
    <!-- BEGIN: Custom Tooltip Content -->
    <div class="tooltip-content">
        <div id="custom-content-tooltip1" class="relative flex items-center py-1">
            <div class="ml-4 mr-auto">
                <div class="text-gray-600">
                    If you need more than 2 houre to pay, click the cock
                    to make sure your recipient gets exactly
                    <strong>1.162.03 GBP</strong>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Custom Tooltip Content -->
</div>
</div>
