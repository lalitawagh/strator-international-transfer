<div>
    <div class="modal-body">
        @if ($sent_resend_otp == true)
            <h4 class="text-success mb-2">OTP Resend Successfully</h4>
        @endif
        <div class="p-0">
            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
                <div class="col-span-12 md:col-span-12 form-inline">
                    <label for="mobile" class="form-label sm:w-16">Mobile <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6 tillselect-marging">
                        <div class="input-group flex flex-col sm:flex-row mb-0 mt-0">
                            <div id="input-group-phone" wire:ignore class="input-group-text flex form-inline"
                                style="padding: 0 5px;">

                                <span id="countryWithPhoneFlagImgTransferOtp"
                                    style="display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            align-self: center;margin-right:10px;">
                                    @foreach ($countries as $country)
                                        @if ($country->id == old('country_code', $defaultCountry->id))
                                            <img src="{{ $country->flag }}">
                                        @endif
                                    @endforeach
                                </span>

                                <select id="countryWithPhone" name="country_code" onchange="getFlagImg(this,'Otp')"
                                    data-search="true" class="tom-select">
                                    @foreach ($countries as $country)
                                        <option data-source="{{ $country->flag }}" value="{{ $country->id }}"
                                            @if ($country->id == old('country_code', $defaultCountry->id)) selected @else disabled @endif>
                                            {{ $country->code }} ({{ $country->phone }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input name="mobile" value="{{ $user->phone }}" type="number"
                                class="form-control @error('phone') border-theme-6 @enderror"
                                onKeyPress="if(this.value.length==11) return false;return onlyNumberKey(event);"
                                disabled>

                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-12 form-inline">
                    <label for="code" class="form-label sm:w-16">OTP <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="code" wire:model.defer="code" name="code" type="text"
                            class="form-control" required="required">
                        @error('code')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                        <a wire:click="resendOtp()" class="block text-theme-1 mt-2" style="cursor: pointer;">Resend OTP
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-right mt-5">
                <button wire:click="verifyOtp" type="button" class="btn btn-primary w-24">Submit</button>
            </div>
        </div>
    </div>
</div>
