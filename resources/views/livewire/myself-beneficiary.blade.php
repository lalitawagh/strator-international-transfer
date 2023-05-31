<div>
    <div class="p-0" x-data="{ selectedDiv: 'personal' }">

        <form>
            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0 lg:mb-0">
                <div class="col-span-12 md:col-span-8 lg:col-span-6 form-inline lg:mt-0">
                    <label class="form-label sm:w-52">Contact Type <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6 sm:pt-1">
                        <div class="flex sm:flex-row mt-2">
                            <div class="form-check mr-6 mb-2">
                                <input id="type-personal" class="form-check-input contact-type" wire:model="type"
                                    wire:click="selectBeneficiaryType($event.target.value)"
                                    x-on:click="selectedDiv = 'personal'" type="radio" name="type" value="personal"
                                    checked="">
                                <label class="form-check-label" for="type-personal">Personal</label>
                            </div>
                            <div class="form-check mr-2 mb-2 sm:mt-0">
                                <input id="type-company" class="form-check-input contact-type" wire:model="type"
                                    wire:click="selectBeneficiaryType($event.target.value)"
                                    x-on:click="selectedDiv = 'business'" type="radio" name="type"
                                    value="business">
                                <label class="form-check-label" for="type-company">Company</label>
                            </div>
                        </div>
                        @error('type')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 md:gap-0 lg:gap-10 mt-0 ihphone-scroll-height-inr">

                <div class="col-span-12 md:col-span-8 lg:col-span-6 lg:mt-0">

                    <div class="col-span-12 md:col-span-6 form-inline mt-2" id="sectionRefresh">
                        <label for="bank_country" class="form-label sm:w-52"> Country <span
                                class="text-theme-6">*</span></label>
                        <div class="sm:w-5/6">
                            {{-- <select id="{{ $beneficiaryType }}_country_id" name="bank_country" data-search="true"
                                wire:change="changeCountry($event.target.value)" class="w-full">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        @if ($country->code == $receiving_country) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select> --}}
                            <input id="bank_country" name="bank_country" type="text"
                                class="form-control" value="{{ $receiving_countrys }}" disabled>
                            @error('meta.bank_country')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 form-inline mt-2"
                        @if ($type == 'business') style="display:none" @endif>
                        <label for="first_name" class="form-label sm:w-52">First Name <span
                                class="text-theme-6">*</span></label>
                        <div class="sm:w-5/6">
                            <input id="first_name" wire:model.defer="first_name" name="first_name" type="text"
                                class="form-control" value="{{ $user->first_name }}" required="required">
                            @error('first_name')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 form-inline mt-2"
                        @if ($type == 'business') style="display:none" @endif>
                        <label for="middle_name" class="form-label sm:w-52">Middle Name</label>
                        <div class="sm:w-5/6">
                            <input id="middle_name" wire:model.defer="middle_name" name="middle_name" type="text"
                                class="form-control" value="{{ $user->middle_name }}">
                            @error('middle_name')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 form-inline mt-2 contact-personal visible"
                        @if ($type == 'business') style="display:none" @endif>
                        <label for="last_name" class="form-label sm:w-52">Last Name <span
                                class="text-theme-6">*</span></label>
                        <div class="sm:w-5/6">
                            <input id="last_name" wire:model.defer="last_name" name="last_name" type="text"
                                class="form-control" value="{{ $user->last_name }}" required="required">
                            @error('last_name')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 form-inline mt-2 contact-personal visible"
                        @if ($type == 'personal') style="display:none" @endif>
                        <label for="company_name" class="form-label sm:w-52">Company Name <span
                                class="text-theme-6">*</span></label>
                        <div class="sm:w-5/6">
                            <input id="company_name" wire:model.defer="company_name" name="company_name" type="text"
                                class="form-control" required="required">
                            @error('company_name')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 form-inline mt-2">
                        <label for="email" class="form-label sm:w-52">Email Address </label>
                        <div class="sm:w-5/6">
                            <input id="email" wire:model.defer="email" name="email" type="email"
                                class="form-control" value="{{ $user->email }}">
                            @error('email')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 form-inline mt-2">
                        <label for="mobile" class="form-label sm:w-52">Mobile No. </label>
                        <div class="sm:w-5/6 mob">
                            <div class="input-group flex flex-col sm:flex-row mb-0 mt-0">
                                <div id="input-group-phone" wire:ignore class="input-group-text flex form-inline"
                                    style="padding: 0 5px;">

                                    <span id="countryWithPhoneFlagImgTransfer{{ $beneficiaryType }}"
                                        style="display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            align-self: center;margin-right:10px;">
                                        @foreach ($countries as $country)
                                            @if ($country->id == old('country_code'))
                                                <img src="{{ $country->flag }}">
                                            @elseif ($country->code == $receiving_country)
                                                <img src="{{ $country->flag }}">
                                            @endif
                                        @endforeach
                                    </span>

                                    <select id="countryWithPhone" name="country_code"
                                        onchange="getFlagImg(this,'{{ $beneficiaryType }}')" data-search="true"
                                        class="w-full">
                                        @foreach ($countries as $country)
                                            <option data-source="{{ $country->flag }}" value="{{ $country->id }}"
                                                @if ($country->id == old('country_code')) selected @elseif ($country->code == $receiving_country) selected @endif>
                                                {{ $country->code }} ({{ $country->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input wire:model.defer="mobile" name="mobile" type="number"
                                    class="form-control @error('phone') border-theme-6 @enderror"
                                    onKeyPress="if(this.value.length==11) return false;return onlyNumberKey(event);">

                            </div>
                            @error('mobile')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 form-inline mt-2">
                        <label for="landline" class="form-label sm:w-52">Phone </label>
                        <div class="sm:w-5/6 mob">
                            <div class="input-group flex flex-col sm:flex-row mb-0 mt-0">
                                <div id="input-group-phone" wire:ignore class="input-group-text flex form-inline"
                                    style="padding: 0 5px;">

                                    <span id="countryWithLandlineFlagImgTransfer{{ $beneficiaryType }}"
                                        style="display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            align-self: center;margin-right:10px;">
                                        @foreach ($countries as $country)
                                            @if ($country->id == old('country_code'))
                                                <img src="{{ $country->flag }}">
                                            @elseif ($country->code == $receiving_country)
                                                <img src="{{ $country->flag }}">
                                            @endif
                                        @endforeach
                                    </span>

                                    <select id="countryWithPhone" name="country_code"
                                        onchange="getFlagImgLandline(this,'{{ $beneficiaryType }}')"
                                        data-search="true" class="w-full">
                                        @foreach ($countries as $country)
                                            <option data-source="{{ $country->flag }}" value="{{ $country->id }}"
                                                @if ($country->id == old('country_code')) selected @elseif ($country->code == $receiving_country) selected @endif>
                                                {{ $country->code }} ({{ $country->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input id="landline" wire:model.defer="landline" name="landline" type="text"
                                    class="form-control" value="">

                            </div>

                            @error('landline')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="col-span-12 md:col-span-8 lg:col-span-6 lg:mt-0">
                    <div class="col-span-12 md:col-span-6 form-inline mt-2">
                        <label for="bank_account_name" class="form-label sm:w-52"> Account Name <span
                                class="text-theme-6">*</span></label>
                        <div class="sm:w-5/6">
                            <input id="bank_account_name" wire:model.defer="meta.bank_account_name"
                                name="bank_account_name" type="text" class="form-control" required="">
                            @error('meta.bank_account_name')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BBSP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="branch_code" class="form-label sm:w-52">Branch Code <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="branch_code" wire:model.defer="meta.branch_code" name="branch_code"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.branch_code')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="col-span-12 md:col-span-6 form-inline mt-2 contact-personal visible">
                        @unless (in_array($receiving_country, \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::I]))
                        <label for="bank_account_number" class="form-label sm:w-52">Account No <span class="text-theme-6">*</span></label>
                        <div class="sm:w-5/6">
                            <input id="bank_account_number" wire:model.defer="meta.bank_account_number"
                                name="bank_account_number" type="text" class="form-control" required="required">
                            @error('meta.bank_account_number')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        @endunless
                    </div>


                    @if (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::IB]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="iban_number" class="form-label sm:w-52">IBAN <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="iban_number" wire:model.defer="meta.iban_number" name="iban_number"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.iban_number')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BIA]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="bic_number" class="form-label sm:w-52">BIC/SWIFT<span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="bic_number" wire:model.defer="meta.bic_number" name="bic_number"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.bic_number')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BAP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="bsb_number" class="form-label sm:w-52">BSB Code<span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="bsb_number" wire:model.defer="meta.bsb_number" name="bsb_number"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.bsb_number')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::AASP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="aba_number" class="form-label sm:w-52">ABA Code <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="aba_number" wire:model.defer="meta.aba_number" name="aba_number"
                                    type="text" class="form-control" required="required">
                                @error('meta.aba_number')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BBSP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="bank_code" class="form-label sm:w-52">Bank Code <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="bank_code" wire:model.defer="meta.bank_code" name="bank_code"
                                    type="text" class="form-control" required="required">
                                @error('meta.bank_code')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::I]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="iban_number" class="form-label sm:w-52">IBAN <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="iban_number" wire:model.defer="meta.iban_number" name="iban_number"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.iban_number')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BASP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="bic_number" class="form-label sm:w-52">BIC / SWIFT<span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="bic_number" wire:model.defer="meta.bic_number" name="bic_number"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.bic_number')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BA]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="bank_code" class="form-label sm:w-52">Bank Code <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="bank_code" wire:model.defer="meta.bank_code" name="bank_code"
                                    type="text" class="form-control" required="required">
                                @error('meta.bank_code')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BCSP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="bic_number" class="form-label sm:w-52">BIC / SWIFT<span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="bic_number" wire:model.defer="meta.bic_number" name="bic_number"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.bic_number')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::AI]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="iban_number" class="form-label sm:w-52">IFSC Code/ IBAN <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="iban_number" wire:model.defer="meta.iban_number" name="iban_number"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.iban_number')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BBA]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="bank_code" class="form-label sm:w-52">Bank Code <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="bank_code" wire:model.defer="meta.bank_code" name="bank_code"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.bank_code')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::CB]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="cnaps_number" class="form-label sm:w-52">CNAPS<span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="cnaps_number" wire:model.defer="meta.cnaps_number" name="cnaps_number"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.cnaps_number')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::SA]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="bank_code" class="form-label sm:w-52">Sort Code <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="bank_code" wire:model.defer="meta.bank_code" name="bank_code"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.bank_code')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="col-span-12 md:col-span-6 form-inline mt-2">
                        <label for="avatar" class="form-label sm:w-52">Avatar</label>
                        <div class="sm:w-5/6">
                            <input id="avatar" wire:model="avatar" name="avatar" type="file"
                                class="form-control " value="">
                            @error('avatar')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 form-inline mt-2">
                        <label for="benficiary_address" class="form-label sm:w-52">Address <span
                                class="text-theme-6">*</span></label>
                        <div class="sm:w-5/6">
                            <input id="benficiary_address" wire:model.defer="meta.benficiary_address"
                                name="benficiary_address" type="text" class="form-control">
                            @error('meta.benficiary_address')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BAP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="post_code" class="form-label sm:w-52">Post Code <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="post_code" wire:model.defer="meta.post_code" name="post_code"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.post_code')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    @if (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::AASP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="post_code" class="form-label sm:w-52">Post Code <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="post_code" wire:model.defer="meta.post_code" name="post_code"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.post_code')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    @if (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::AASP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="benficiary_state" class="form-label sm:w-52">State/Privence <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="benficiary_state" wire:model.defer="meta.benficiary_state"
                                    name="benficiary_state" type="text" class="form-control">
                                @error('meta.benficiary_state')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    @if (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BBSP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="post_code" class="form-label sm:w-52">Post Code <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="post_code" wire:model.defer="meta.post_code" name="post_code"
                                    type="text" class="form-control" required="required" value="">
                                @error('meta.post_code')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    @if (in_array(
                            $receiving_country,
                            \Kanexy\InternationalTransfer\Enums\ShortCode::SHORT_CODE[\Kanexy\InternationalTransfer\Enums\ShortCode::BBSP]))
                        <div class="col-span-12 md:col-span-6 form-inline mt-2">
                            <label for="benficiary_state" class="form-label sm:w-52">State/Privence <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="benficiary_state" wire:model.defer="meta.benficiary_state"
                                    name="benficiary_state" type="text" class="form-control">
                                @error('meta.benficiary_state')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="col-span-12 md:col-span-6 form-inline mt-2">
                        <label for="benficiary_city" class="form-label sm:w-52">City <span
                                class="text-theme-6">*</span></label>
                        <div class="sm:w-5/6">
                            <input id="benficiary_city" wire:model.defer="meta.benficiary_city"
                                name="benficiary_city" type="text" class="form-control">
                            @error('meta.benficiary_city')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 form-inline mt-2" style="align-items: initial;">
                        <label for="note" class="form-label sm:w-52">Notes </label>
                        <div class="sm:w-5/6">
                            <textarea class="form-control" wire:model.defer="note" name="note"></textarea>
                            @error('note')
                                <span class="block text-theme-6 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <button id="BeneficiaryCreate" wire:click="createBeneficiary" type="button"
                    class="btn btn-primary w-24">Create</button>
            </div>
        </form>
    </div>

</div>
