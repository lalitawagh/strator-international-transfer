@extends('international-transfer::configuration.skeleton')

@section('title', 'Update Exchange Rate')

@section('config-content')
    <div class="configuration-container w-screen">
        <div class="grid grid-cols-8 gap-0">
            <div class="intro-y box col-span-5 xxl:col-span-12 bg-gray-100 p-4">
                <div class="p-5">
                    @if (Session::has('error'))
                        <span class="block text-theme-6">{{ Session::get('error') }}</span>
                    @endif
                    @error('alreadyexists')
                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                    @enderror
                    <form action="{{ route('dashboard.international-transfer.exchange-rate.update', $ExchangeRate['id']) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-12 gap-2" x-show="selected == '1'">
                            <div class="col-span-12 md:col-span-6 xl:col-span-6 form-inline mt-2">
                                <label for="exchange_from" class="form-label sm:w-30">Exchange From <span
                                        class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6 tillselect-marging">
                                    <select name="exchange_from" id="exchange_from" data-search="true"
                                        class="w-full @error('exchange_from') border-theme-6 @enderror" required>
                                        @foreach ($countries as $country)
                                            @php
                                                $selected = old('exchange_from') == $country->id || (isset($ExchangeRate) && $ExchangeRate->exchange_from == $country->id);
                                            @endphp
                                            <option value="{{ $country->id }}" {{ $selected ? 'selected' : '' }}>
                                                {{ $country->currency }} ({{ $country->code }}) {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('exchange_from')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-6 xl:col-span-6 form-inline mt-2">
                                <label for="exchange_to" class="form-label sm:w-30">Exchange To <span
                                        class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6 tillselect-marging">
                                    <select name="exchange_to" id="exchange_to" data-search="true"
                                        class="w-full @error('exchange_to') border-theme-6 @enderror" required>
                                        @foreach ($countries as $country)
                                            @php
                                                $selected = old('exchange_to') == $country->id || (isset($ExchangeRate) && $ExchangeRate->exchange_to == $country->id);
                                            @endphp
                                            <option value="{{ $country->id }}" {{ $selected ? 'selected' : '' }}>
                                                {{ $country->currency }} ({{ $country->code }}) {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('exchange_to')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-12 xl:col-span-10 form-inline mt-2"
                                @if (old('rate_type', $ExchangeRate) == 'customized_rate') x-data="{ selected: '1' }"
                                @elseif (old('rate_type', $ExchangeRate) == 'default_rate') x-data="{ selected: '0' }" @else x-data="{ selected: '3' }" @endif>
                                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                                    <label for="rate_type_info" class="form-label sm:w-30">Rate Type <span
                                            class="text-theme-6">*</span></label>
                                    <div class="sm:w-5/6 sm:pt-3">
                                        <div class="form-check mr-2">
                                            <input id="radio-switch-1" class="form-check-input" type="radio"
                                                x-on:click="selected = '1'" name="rate_type" value="customized_rate"
                                                @if (old('rate_type', $ExchangeRate) == 'customized_rate') checked @endif>
                                            <label class="form-check-label" for="radio-switch-1">
                                                <h4 href="javascript:;" class="font-medium truncate mr-5 ">
                                                    <h4>Customized Rate</h4>
                                            </label>
                                            <input id="radio-switch-2" class="form-check-input ml-3" type="radio"
                                                x-on:click="selected = '0'" name="rate_type" value="default_rate"
                                                @if (old('rate_type', $ExchangeRate) == 'default_rate') checked @endif>
                                            <label class="form-check-label" for="radio-switch-2">
                                                <h4 href="javascript:;" class="font-medium truncate mr-5">
                                                    <h4> Default Rate </h4>
                                            </label>

                                        </div>
                                        @error('rate_type')
                                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 lg:gap-3 xl:gap-10 ml-8">

                                    <div class="col-span-12 md:col-span-12 xl:col-span-12 form-inline mt-2"
                                        x-show="selected == '1'">
                                        <label for="customized_rate" class="form-label sm:w-30">Customized Rate </label>
                                        <div class="sm:w-5/6">
                                            <input id="customized_rate" name="customized_rate" type="number" step="0.01"
                                                class="form-control @error('customized_rate') border-theme-6 @enderror customized_rate"
                                                value="{{ old('customized_rate', $ExchangeRate->customized_rate) }}">

                                            @error('customized_rate')
                                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 md:col-span-12 xl:col-span-12 form-inline mt-2"
                                        x-show="selected == '0'">
                                        <label for="percentage" class="form-label sm:w-30">Plus / Minus</label>
                                        <div class="sm:w-5/6">
                                            <div class="input-group">
                                                <select name="plus_minus" id="percentage_rate" class="form-control"
                                                    data-search="true">
                                                    <option value=""></option>
                                                    <option value="plus"
                                                        @if (old('plus_minus', $ExchangeRate->plus_minus) == 'plus') selected @endif> +
                                                    </option>
                                                    <option value="minus"
                                                        @if (old('plus_minus', $ExchangeRate->plus_minus) == 'minus') selected @endif> -
                                                    </option>
                                                </select>
                                            </div>

                                            @error('plus_minus')
                                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 md:col-span-12 xl:col-span-12 form-inline sm:-mt-6 ml-1"
                                        x-show="selected == '0'">
                                        <label for="percentage" class="form-label sm:w-30">Percentage</label>
                                        <div class="sm:w-5/6">
                                            <div class="input-group">
                                                <input id="percentage" name="percentage" type="number" step="0.01"
                                                    class="form-control @error('percentage') border-theme-6 @enderror percentage"
                                                    value="{{ old('percentage', $ExchangeRate->percentage) }}">
                                                <div id="input-group-percentage" class="input-group-text">%</div>
                                            </div>

                                            @error('percentage')
                                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-5">
                            <a id="exchangeRateEditCancel"
                                href="{{ route('dashboard.international-transfer.exchange-rate.index') }}"
                                class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                            <button id="exchangeRateUpdate" type="submit" class="btn btn-primary w-24">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
