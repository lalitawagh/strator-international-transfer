@extends("cms::dashboard.layouts.default")

@section("title", "Create CC Partner")

@section("content")
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="flex items-center py-2 px-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Create CC Partner
                    </h2>
                </div>

                <div class="p-5">
                    <form action="{{ route('dashboard.international-transfer.cc-partners.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="title" class="form-label sm:w-40">Title <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <select name="title_id" id="title_id" class="tail-select w-full" data-search="true">
                                        @foreach ($titles as $title)
                                            <option value="{{ $title->getKey() }}">{{ $title->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('title')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="first_name" class="form-label sm:w-40">First Name <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="first_name" name="first_name" type="text"
                                        class="form-control @error('first_name') border-theme-6 @enderror"
                                        value="{{ old('first_name') }}" required>

                                    @error('first_name')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="middle_name" class="form-label sm:w-40">Middle Name</label>
                                <div class="sm:w-5/6">
                                    <input id="middle_name" name="middle_name" type="text"
                                        class="form-control @error('middle_name') border-theme-6 @enderror"
                                        value="{{ old('middle_name') }}">

                                    @error('middle_name')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="last_name" class="form-label sm:w-40">Last Name <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="last_name" name="last_name" type="text"
                                        class="form-control @error('last_name') border-theme-6 @enderror"
                                        value="{{ old('last_name') }}" required>

                                    @error('last_name')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="email" class="form-label sm:w-40">Email <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="email" name="email" type="email"
                                        class="form-control @error('email') border-theme-6 @enderror"
                                        value="{{ old('email') }}" required>

                                    @error('email')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="phone" class="form-label sm:w-40">Phone <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="phone" name="phone" type="text"
                                        class="form-control @error('phone') border-theme-6 @enderror"
                                        value="{{ old('phone') }}"  onKeyPress="if(this.value.length==11) return false;" required>

                                    @error('phone')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="country" class="form-label sm:w-40">Country <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <select name="country_id" id="country_id" class="tail-select w-full" data-search="true">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->getKey() }}" @if($defaultCountry->id == $country->getKey()) selected @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('country_id')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                             <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="password" class="form-label sm:w-40">Password <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="password" name="password" type="password"
                                        class="form-control @error('password') border-theme-6 @enderror"
                                        value="{{ old('password') }}" required>

                                    @error('password')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="password_confirmation" class="form-label sm:w-40"> Confirm Password <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        class="form-control @error('password_confirmation') border-theme-6 @enderror"
                                        value="{{ old('password_confirmation') }}"  onKeyPress="if(this.value.length==11) return false;" required>

                                    @error('password_confirmation')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="country_code" class="form-label sm:w-40">Country Code <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <select name="country_code" id="country_code" class="tail-select w-full" data-search="true">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->getKey() }}" @if($defaultCountry->id == $country->getKey()) selected @endif >{{ $country->name }} ({{ $country->phone }})</option>
                                        @endforeach
                                    </select>

                                    @error('country_code')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="webhook_url" class="form-label sm:w-40">Webhook Url</label>
                                <div class="sm:w-5/6">
                                    <input id="webhook_url" name="webhook_url" type="text"
                                        class="form-control @error('webhook_url') border-theme-6 @enderror"
                                        value="{{ old('webhook_url') }}">

                                    @error('webhook_url')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="status" class="form-label sm:w-40"> Status <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6 form-check form-switch">
                                    <input id="status" name="status" type="checkbox" class="form-check-input mr-3" checked="">

                                    @error('status')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-5">
                            <a href="{{ route('dashboard.international-transfer.cc-partners.index') }}" class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-24">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
