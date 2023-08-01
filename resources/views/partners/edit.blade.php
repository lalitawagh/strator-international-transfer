@extends("cms::dashboard.layouts.default")

@section("title", "Edit CC Partner")

@section("content")
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="flex items-center py-2 px-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Edit CC Partner
                    </h2>
                </div>
               
                <div class="p-5">
                    <form action="{{ route('dashboard.international-transfer.cc-partners-update', $partner->getKey()) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="title" class="form-label sm:w-40">Title <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <select name="title_id" id="title_id" class="tail-select w-full" data-search="true">
                                        @foreach ($titles as $title)
                                            <option value="{{ $title->getKey() }}" @if(old('title_id',$partner->title_id) == $title->getKey()) selected @endif>{{ $title->name }}</option>
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
                                        value="{{ old('first_name', $partner->first_name) }}" required>

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
                                        value="{{ old('middle_name', $partner->middle_name) }}">

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
                                        value="{{ old('last_name', $partner->last_name) }}" required>

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
                                        value="{{ old('email', $partner->email) }}" required>

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
                                        value="{{ old('phone', $partner->phone) }}"  onKeyPress="if(this.value.length==11) return false;" required>

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
                                            <option value="{{ $country->getKey() }}" @if(old('country_id',$partner->country_id) == $country->getKey()) selected @endif>{{ $country->name }}</option>
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
                                <label for="country_code" class="form-label sm:w-40">Country Code <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <select name="country_code" id="country_code" class="tail-select w-full" data-search="true">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->getKey() }}" @if(old('country_code',$partner->country_code) == $country->getKey()) selected @endif>{{ $country->name }} ({{ $country->phone }})</option>
                                        @endforeach
                                    </select>

                                    @error('country_code')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="webhook_url" class="form-label sm:w-40">Webhook Url <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="webhook_url" name="webhook_url" type="text"
                                        class="form-control @error('webhook_url') border-theme-6 @enderror"
                                        value="{{ old('webhook_url', $partner->webhook_url) }}">

                                    @error('webhook_url')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 md:gap-10 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="kyc_url" class="form-label sm:w-40">Kyc Url <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="kyc_url" name="kyc_url" type="text"
                                        class="form-control @error('kyc_url') border-theme-6 @enderror"
                                        value="{{ old('kyc_url',$partner->kyc_url) }}">

                                    @error('kyc_url')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="status" class="form-label sm:w-40"> Status <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6 form-check form-switch">
                                    <input id="status" name="status" type="checkbox" class="form-check-input mr-3" @if($partner->status == 'active') checked @endif>

                                    @error('status')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 md:gap-10 mt-2">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="client_id" class="form-label sm:w-40">Client ID <span class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="client_id" name="client_id" type="text" class="form-control w-full" value="{{ $client?->id }}" disabled>
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="client_secret" class="form-label sm:w-40">Client Secret</label>
                                <div class="sm:w-5/6">
                                    <input id="client_secret" name="client_secret" type="text" class="form-control w-full" value="{{ $client?->secret }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-5">
                            <a href="{{ route('dashboard.international-transfer.cc-partners.index') }}" class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-24">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
