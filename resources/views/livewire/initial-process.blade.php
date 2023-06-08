<div>
    <div class="mb-4 relative z-10">
        <input wire:model="amount"
            class="dark:bg-darkmode-400 dark:border-darkmode-400 input border border-gray-400 appearance-none rounded w-full px-3 py-3 pt-5 pb-2 focus focus:border-indigo-600 focus:outline-none active:outline-none active:border-indigo-600"
            name="amount" onpaste="return false;" onkeypress="preventNonNumericalInput(event,this)" autofocus>
        <label
            class="label absolute mb-0 -mt-0 pt-0 pl-3 leading-tighter text-gray-400 text-base mt-0 cursor-text">Sending</label>
        <div id="input-group-email" class="input-group-text form-inline cuntery-in flex gap-2">
            <span id="fromCountry">
                @foreach ($sendingcountriesinfo as $country)
                    @isset($currency_from)
                        @if ($country->id == $currency_from)
                            <img src="{{ $country->flag }}">
                        @endif
                    @else
                        @if ($country->id == $defaultCountry->id)
                            <img src="{{ $country->flag }}">
                        @endif
                    @endisset
                @endforeach
            </span>
            <select class="tail-select w-full" id='tabcuntery-selection1' style='width: 210px;'
                wire:change="changeFromCurrency($event.target.value)" class="" name="currency_code_from">
                @foreach ($sendingcountriesinfo as $country)
                    @if(config('services.registration_changed') == true && $country->code == 'UK')
                        <option data-source="{{ $country->flag }}" value="{{ $country->id }}"
                            @isset($currency_from) @if ($country->id == $currency_from)
                                    selected @endif
                        @else @if ($country->id == $defaultCountry->id) selected @endif @endisset>
                            {{ $country->currency }} ({{ $country->code }}) {{ $country->name }}
                        </option>
                    @else
                        <option data-source="{{ $country->flag }}" value="{{ $country->id }}"
                            @isset($currency_from) @if ($country->id == $currency_from)
                                    selected @endif
                        @else @if ($country->id == $defaultCountry->id) selected @endif @endisset>
                            {{ $country->currency }} ({{ $country->code }}) {{ $country->name }}
                        </option>
                    @endif
                @endforeach

            </select>
        </div>

    </div>
    @error('amount')
        <span class="block text-theme-6 mt-2 mb-2">{{ $message }}</span>
    @enderror

    <div class="mb-4 relative mt-center">
        <ul
            class="sequence sequence-top sequence-bottom tw-calculator-breakdown tw-calculator-breakdown--detailed sequence-inverse tw-calculator-breakdown--inverse">
            <input type="hidden" name="fee_charge"
                value="@isset($fee_charge) {{ $fee_charge }} @endisset">

            <li>
                <span
                    class="dark:bg-darkmode-400 dark:border-darkmode-400 sequence-icon tw-calculator-breakdown__icon">–</span>
                <span class="tw-calculator-breakdown-item__left">
                    <strong>
                        @isset($fee_charge)
                            {{ $fee_charge }}
                        @endisset {{ $from }}
                    </strong>
                </span>
                <span class="tw-calculator-breakdown-item__right">
                    <span class="m-r-1" data-tracking-id="calculator-payment-select">
                        <div class="intro-x dropdown mr-auto sm:mr-3">
                            <div class="dropdown-toggle notification cursor-pointer" role="button"
                                aria-expanded="false" data-tw-toggle="dropdown">
                                <button id="InternationalTransfer" type="button"
                                    class="btn btn-sm btn-secondary mr-4 mb-0">
                                    @isset($fees)
                                        @if (array_search('payment_type', array_column($fees, 'type')) === 0)
                                            {{ trans('international-transfer::configuration.payment_methods') }}
                                        @else
                                            {{ trans('international-transfer::configuration.transfer_types') }}
                                        @endif
                                    @endisset
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>

                            <div class="notification-content pt-2 dropdown-menu">
                                <div
                                    class="dark:bg-darkmode-300 dark:border-darkmode-300 notification-content__box dropdown-menu__content box dark:bg-dark-6">
                                    @isset($fees)
                                        @foreach ($fees as $key => $fee)
                                            @if ($fee['status'] == \Kanexy\InternationalTransfer\Enums\Status::ACTIVE)
                                                @if (!empty($amount) && $amount != '.')
                                                    @php
                                                        $fee_charge = $fee['percentage'] == 0 ? $fee['amount'] : $amount * ($fee['percentage'] / 100);
                                                    @endphp
                                                @else
                                                    @php
                                                        $fee_charge = 0;
                                                    @endphp
                                                @endif
                                                @php

                                                    $country = \Kanexy\Cms\I18N\Models\Country::find($currency_from);
                                                @endphp
                                                @if ($amount >= $fee['min_amount'] && $amount <= $fee['max_amount'])
                                                    <div
                                                        class="dark:bg-darkmode-400 dark:border-darkmode-400 cursor-pointer relative items-center cursor-pointer relative items-center px-1 py-1 break-all cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md  ">
                                                        <div class="ml-0 overflow-hidden">
                                                            <div class="flex flex-col sm:flex-row mt-2 m-2">
                                                                <div class="form-check mr-2">
                                                                    <input id="radio-switch-{{ $key }}"
                                                                        class="form-check-input" type="radio"
                                                                        name="feeMethod" wire:model="feeMethod"
                                                                        value="{{ $fee['id'] }}"
                                                                        @if ($feeMethod == $fee['id']) checked @endif
                                                                        wire:click="$emit('changeToMethod','{{ $fee_charge }}')">
                                                                    <label class="form-check-label"
                                                                        for="radio-switch-{{ $key }}">
                                                                        <h4 href="javascript:;" class="font-medium  mr-5">
                                                                            @if ($fee['type'] == 'payment_type')
                                                                                {{ $fee['payment_type'] }}
                                                                            @elseif ($fee['type'] == 'transfer_type')
                                                                                {{ $fee['transfer_type'] }}
                                                                            @endif
                                                                            -{{ number_format((float) $fee_charge, 2, '.', '') }}
                                                                            {{ $country->currency }}
                                                                            @if ($fee['percentage'] != 0)
                                                                                ({{ $fee['percentage'] }} %)
                                                                            @endif
                                                                            Fee
                                                                        </h4>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="w-full truncate text-gray-600 mt-2 m-2">
                                                                {{ $fee['description'] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </span>
                    <span style="text-transform:none">Fee</span>
                </span>

            </li>
            <li><span
                    class="dark:bg-darkmode-400 dark:border-darkmode-400 sequence-icon tw-calculator-breakdown__icon">=</span>
                <span class="tw-calculator-breakdown-item__left">{{ $fee_deduction_amount }}
                    {{ $from }}</span>
                <span class="tw-calculator-breakdown-item__right">Amount we'll convert</span>
            </li>
            <li>
                <input type="hidden" name="guaranteed_rate"
                    value="@isset($guaranteed_rate) {{ $guaranteed_rate }} @endisset">
                <span
                    class="dark:bg-darkmode-400 dark:border-darkmode-400 sequence-icon tw-calculator-breakdown__icon">x</span>
                <span class="tw-calculator-breakdown-item__left">{{ $guaranteed_rate }}</span>
                <span class="tw-calculator-breakdown-item__right">Exchange Rate</span>
            </li>
        </ul>
    </div>
    <div class="mb-4 relative z-10">
        <input wire:model="recipient_amount"
            class="dark:bg-darkmode-400 dark:border-darkmode-400 input border border-gray-400 appearance-none rounded w-full px-3 py-3 pt-5 pb-2 focus focus:border-indigo-600 focus:outline-none active:outline-none active:border-indigo-600"
            name="recipient_amount" onkeypress="preventNonNumericalInput(event)" readonly autofocus>
        <label
            class="label absolute mb-0 -mt-0 pt-0 pl-3 leading-tighter text-gray-400 text-base mt-0 cursor-text">Receiving</label>
        <div id="input-group-email" class="input-group-text form-inline cuntery-in flex gap-2">
            <span id="toCountry">
                @foreach ($receivingcountriesinfo as $country)
                    @isset($currency_to)
                        @if ($country->id == $currency_to)
                            <img src="{{ $country->flag }}">
                        @endif
                    @else
                        @if ($country->code == 'IN')
                            <img src="{{ $country->flag }}">
                        @endif
                    @endisset
                @endforeach
            </span>
            <select class="tail-select w-full" id='tabcuntery-selection2'
                wire:change="changeToCurrency($event.target.value)" name="currency_code_to">
                @if(config('services.registration_changed') == true)
                    @foreach ($receivingcountriesinfo as $country)
                        @if ($country?->risk_score != 3)
                            <option data-source="{{ $country->flag }}" value="{{ $country->id }}"
                                @isset($currency_to)
                            @if ($country->id == $currency_to)
                                selected
                            @endif
                            @else @if ($country->code == 'IN')
                                selected
                            @endif @endisset>
                                {{ $country->currency }} ({{ $country->code }}) {{ $country->name }}
                            </option>
                        @endif
                    @endforeach
                @else
                    @foreach ($countries as $country)
                        @if ($country?->risk_score != 3)
                            <option data-source="{{ $country->flag }}" value="{{ $country->id }}"
                                @isset($currency_to)
                            @if ($country->id == $currency_to)
                                selected
                            @endif
                            @else @if ($country->code == 'IN')
                                selected
                            @endif @endisset>
                                {{ $country->currency }} ({{ $country->code }}) {{ $country->name }}
                            </option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
