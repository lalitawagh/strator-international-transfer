<div class="grid grid-cols-12 md:gap-3 lg:gap-3 xl:gap-8 mt-0">
    <div class="col-span-12 md:col-span-12 lg:col-span-6 form-inline mt-2">
        <label for="transaction_threshold_amount" class="form-label sm:w-52">Threshold Amount</label>
        <div class="sm:w-5/6">
            <input id="transaction_threshold_amount" name="transaction_threshold_amount" type="text"
                class="form-control @error('transaction_threshold_amount') border-theme-6 @enderror" placeholder=""
                value="{{ old('transaction_threshold_amount', @$settings['transaction_threshold_amount']) }}">

            @error('transaction_threshold_amount')
                <span class="block text-theme-6 mt-2">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
