@extends('partner-foundation::membership.membership-layout.membership-skeleton')

@section('title', 'Exchange Rate Information')

@section('membership-content')

    <div id="ExchangeRate" class="tab-pane grid grid-cols-12 gap-3 active" role="tabpanel" aria-labelledby="ExchangeRate-tab">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box mt-0">
                <div class="flex flex-col sm:flex-row items-center p-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Exchange Rate Information
                    </h2>
                </div>

                <form method="POST"
                    action="{{ route('dashboard.international-transfer.membership.store.exchangerate-information', app('activeWorkspaceId')) }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user?->getKey() }}">

                    <div class="preview p-5" id="exchangerateInformation">
                        <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0"
                            @if (old('rate_type', @$workspaceMeta->value['rate_type']) == 'customize_rate') x-data="{ selected: '1' }" @elseif (old('rate_type', @$workspaceMeta->value['rate_type']) == 'currency_cloud_rate') x-data="{ selected: '0' }" @else x-data="{ selected: '3' }" @endif>
                            <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                                <label for="rate_type_info" class="form-label sm:w-30">Rate Type </label>
                                <div class="sm:w-5/6 sm:pt-3">
                                    <div class="form-check mr-2">
                                        <input id="radio-switch-1" class="form-check-input" type="radio"
                                            x-on:click="selected = (selected === '1') ? '' : '1'" name="rate_type"
                                            value="customize_rate" x-bind:checked="selected === '1'">
                                        <label class="form-check-label" for="radio-switch-1">
                                            <h4 href="javascript:;" class="font-medium truncate mr-5">
                                                Customized Rate
                                            </h4>
                                        </label>
                                        <input id="radio-switch-2" class="form-check-input ml-3" type="radio"
                                            x-on:click="selected = (selected === '0') ? '' : '0'" name="rate_type"
                                            value="currency_cloud_rate" x-bind:checked="selected === '0'">
                                        <label class="form-check-label" for="radio-switch-2">
                                            <h4 href="javascript:;" class="font-medium truncate mr-5">
                                                Currency Cloud Rate
                                            </h4>
                                        </label>
                                        
                                    </div>
                                    @error('rate_type')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2" x-show="selected == '1'">
                                <label for="customized_rate" class="form-label sm:w-30">Customized Rate </label>
                                <div class="sm:w-5/6">
                                    <input id="customized_rate" name="customized_rate" type="text"
                                        class="form-control @error('customized_rate') border-theme-6 @enderror customized_rate"
                                        value="{{ old('customized_rate', @$workspaceMeta->value['customized_rate']) }}">

                                    @error('customized_rate')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-6 lg:col-span-6 xl:col-span-6 form-inline mt-2" x-show="selected == '0'">
                                <label for="percentage" class="form-label sm:w-30">Plus / Minus</label>
                                <div class="sm:w-5/6">
                                    <div class="input-group">
                                        <select name="percentage_rate" id="percentage_rate" class="form-control"
                                            data-search="true">
                                            <option value=""></option>
                                            <option value="plus" @if (old('percentage_rate', @$workspaceMeta->value['percentage_rate']) == 'plus') selected @endif> +
                                            </option>
                                            <option value="minus" @if (old('percentage_rate', @$workspaceMeta->value['percentage_rate']) == 'minus') selected @endif> -
                                            </option>
                                        </select>
                                    </div>

                                    @error('percentage_rate')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2" x-show="selected == '0'">
                                <label for="percentage" class="form-label sm:w-30">Percentage</label>
                                <div class="sm:w-5/6">
                                    <div class="input-group">
                                        <input id="percentage" name="percentage" type="text"
                                            class="form-control @error('percentage') border-theme-6 @enderror percentage"
                                            value="{{ old('percentage', @$workspaceMeta->value['percentage']) }}">
                                        <div id="input-group-percentage" class="input-group-text">%</div>
                                    </div>

                                    @error('percentage')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="text-right">
                            <button id="generalInformationUpdate" type="submit"
                                class="btn btn-primary mt-5 updatePersonalInformation">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
