<div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-8 mt-0"
    @if (old('cc_rate_type', @$rate_type) == 'cc_customize_rate') x-data="{ selected: '1' }" @elseif (old('cc_rate_type', @$rate_type) == 'currency_cloud_rate') x-data="{ selected: '0' }" @else x-data="{ selected: '3' }" @endif>
    <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
        <label for="rate_type_info" class="form-label sm:w-52">Rate Type </label>
        <div class="sm:w-5/6 sm:pt-3">
            <div class="form-check mr-2">
                <input id="radio-switch-1" class="form-check-input" type="radio" x-on:click="selected = '1'"
                    name="cc_rate_type" value="cc_customize_rate" @if (old('cc_rate_type', @$rate_type) == 'cc_customize_rate') checked @endif>
                <label class="form-check-label" for="radio-switch-1">
                    <h4 href="javascript:;" class="font-medium truncate mr-5 ">
                        <h4>Customized Rate</h4>
                </label>
                <input id="radio-switch-2" class="form-check-input ml-3" type="radio" x-on:click="selected = '0'"
                    name="cc_rate_type" value="currency_cloud_rate" @if (old('cc_rate_type', @$rate_type) == 'currency_cloud_rate') checked @endif>
                <label class="form-check-label" for="radio-switch-2">
                    <h4 href="javascript:;" class="font-medium truncate mr-5">
                        <h4>Currency Cloud Rate </h4>
                </label>

            </div>
            @error('cc_rate_type')
                <span class="block text-theme-6 mt-2">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2" x-show="selected == '1'">
        <label for="customized_rate" class="form-label sm:w-52">Customized Rate </label>
        <div class="sm:w-5/6">
            <input id="customized_rate" name="cc_customized_rate" type="text"
                class="form-control @error('cc_customized_rate') border-theme-6 @enderror cc_customized_rate"
                value="{{ old('cc_customized_rate', @$customized_rate) }}">

            @error('cc_customized_rate')
                <span class="block text-theme-6 mt-2">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2" x-show="selected == '0'">
        <label for="percentage" class="form-label sm:w-52">Plus / Minus</label>
        <div class="sm:w-5/6">
            <div class="input-group">
                <select name="cc_percentage_rate" id="percentage_rate" class="form-control" data-search="true">
                    <option value=""></option>
                    <option value="plus" @if (old('cc_percentage_rate', @$percentage_rate) == 'plus') selected @endif> + </option>
                    <option value="minus" @if (old('cc_percentage_rate', @$percentage_rate) == 'minus') selected @endif> - </option>
                </select>
            </div>

            @error('cc_percentage_rate')
                <span class="block text-theme-6 mt-2">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline -mt-5" x-show="selected == '0'">
        <label for="percentage" class="form-label sm:w-52">Percentage</label>
        <div class="sm:w-5/6">
            <div class="input-group">
                <input id="percentage" name="cc_percentage" type="text"
                    class="form-control @error('cc_percentage') border-theme-6 @enderror percentage"
                    value="{{ old('cc_percentage', @$percentage) }}">
                <div id="input-group-percentage" class="input-group-text">%</div>
            </div>

            @error('cc_percentage')
                <span class="block text-theme-6 mt-2">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
