@push('styles')
    <style>
        .country-in {
            --tw-text-opacity: 1;
            color: rgb(var(--color-primary)/var(--tw-text-opacity));
            position: inherit;
            right: 0px;
            height: 48px;
            top: 72%;
            /* transform: translateY(-50%); */
            /* -webkit-transform: translateY(-50%); */
            -moz-transform: translateY(-50%);
            padding: 2px 8px;
            border-radius: 0 5px 5px 0;
            line-height: 27px;
            background-color: rgb(var(--color-primary) / var(--tw-bg-opacity));
        }

        .country-in img {
            min-height: 26px;
        }
        .country-in span {
            display: flex;
            justify-content: center;
            align-items: center;
            align-self: center;
        }

        .country-in .tail-select {
            min-width: 210px;
            max-width: 210px;
        }
        .country-in .tail-select {
            min-width: calc(100% - 50px);
            max-width: 210px;
            margin-top: 0.2rem !important;
            margin-bottom: 0.2rem !important;
        }

        @media (max-width: 840px){
            body .country-in.form-inline {
                display: flex;
            }
        }
    </style>
@endpush
<div>
    <div class="intro-y col-span-12 sm:col-span-12">
            <label for="regular-form-1" class="form-label">
                <h5 class="text-lg font-medium mb-4">Sell</h5>
            </label>
            <div id="input-group-email" class="input-group-text form-inline country-in flex gap-2">
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
                <select class="tail-select w-full" id='tabcuntery-selection1' style=''
                    wire:change="changeFromCurrency($event.target.value)" class="" name="currency_sell">
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
    <br>

    <div class="intro-y col-span-12 sm:col-span-6">
        <label for="regular-form-1" class="form-label">
            <h5 class="text-lg font-medium mb-4">Buy </h5>
        </label>
        <div id="input-group-email" class="input-group-text form-inline country-in flex gap-2">
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
                wire:change="changeToCurrency($event.target.value)" name="currency_buy">
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
    <br>

    <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
        <div class="col-span-12 md:col-span-12 xl:col-span-10 form-inline mt-2"
            @if (old('amount_to', @$amount_to) == 'customized_rate') x-data="{ selected: '1' }"
                @elseif (old('amount_to', @$amount_to) == 'default_rate') x-data="{ selected: '0' }"
                @else x-data="{ selected: '3' }" @endif>
            <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                <label for="amount_to" class="form-label sm:w-30">Amount to </label>
                <div class="sm:w-5/6 sm:pt-3">
                    <div class="form-check mr-2">
                        <input id="radio-switch-1" class="form-check-input" type="radio"
                            x-on:click="selected = '1'" name="amount_to" value="customized_rate"
                            @if (old('amount_to', @$amount_to) == 'sell') checked @endif>
                        <label class="form-check-label" for="radio-switch-1">
                            <h4 href="javascript:;" class="font-medium truncate mr-5 ">
                                <h4>Sell</h4>
                        </label>
                        <input id="radio-switch-2" class="form-check-input ml-3" type="radio"
                            x-on:click="selected = '0'" name="amount_to" value="default_rate"
                            @if (old('amount_to', @$amount_to) == 'buy') checked @endif>
                        <label class="form-check-label" for="radio-switch-2">
                            <h4 href="javascript:;" class="font-medium truncate mr-5">
                                <h4> Buy </h4>
                        </label>
                    </div>
                    @error('amount_to')
                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 lg:gap-3 xl:gap-10 ml-8">

                <div class="col-span-12 md:col-span-12 xl:col-span-12 form-inline mt-2"
                    x-show="selected == '1'">
                    <label for="sell" class="form-label sm:w-30">Sell </label>
                    <div class="sm:w-5/6">
                        <input id="sell" name="sell" type="number" step="0.01"
                            class="form-control @error('sell') border-theme-6 @enderror sell"
                            value="{{ old('sell') }}">

                        @error('sell')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-12 xl:col-span-12 form-inline mt-2"
                    x-show="selected == '0'">
                    <label for="buy" class="form-label sm:w-30">Buy</label>
                    <div class="sm:w-5/6">
                        <div class="input-group">
                            <input id="buy" name="buy" type="number" step="0.01"
                                class="form-control @error('buy') border-theme-6 @enderror"
                                value="{{ old('buy') }}">
                        </div>

                        @error('buy')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function toggleInputField(selectedValue) {
        var inputField = document.getElementById("myslectfiled");

        if (selectedValue === "sell") {
            inputField.style.display = "block";
        } else {
            inputField.style.display = "block";
        }
        }
    </script>
@endpush
