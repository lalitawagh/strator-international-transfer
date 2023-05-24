@extends('cms::dashboard.layouts.default')

@section('title', 'Agent Detail')

@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="flex items-center p-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Agent Detail
                    </h2>
                </div>
                <div class="p-5">
                    <form action="{{ route('dashboard.international-transfer.agent.update',$user?->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-8 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="first_name" class="form-label sm:w-32">First Name <span
                                        class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="first_name" name="first_name" type="text"
                                        class="form-control @error('first_name') border-theme-6 @enderror"
                                        value="{{ old('first_name',$user?->first_name) }}" required>

                                    @error('first_name')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="last_name" class="form-label sm:w-32"> Last Name <span
                                        class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="last_name" name="last_name" type="text"
                                        class="form-control @error('last_name') border-theme-6 @enderror"
                                        value="{{ old('last_name',$user?->last_name) }}" required>

                                    @error('last_name')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-8 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="email" class="form-label sm:w-32">Email Address <span
                                        class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="email" name="email" type="email"
                                        class="form-control @error('email') border-theme-6 @enderror"
                                        value="{{ old('email',$user?->email) }}" required>

                                    @error('email')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-6 gap-2 form-inline mt-2">
                                <label for="phone" class="form-label sm:w-32">Mobile Number <span
                                        class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <div class="input-group mobileNumber">
                                        <div id="input-group-email"
                                            class="input-group-text flex form-inline"style="padding: 0 5px 0 0;">
                                            <span id="countryWithPhoneFlagImg"
                                                style="display: flex; justify-content: center; align-items: center; align-self: center;">
                                                @foreach ($countryWithFlags as $country)
                                                    @if ($country->id == old('country_code', $defaultCountry->id))
                                                        <img src="{{ $country->flag }}">
                                                    @endif
                                                @endforeach
                                            </span>

                                            <select id="countryWithPhone" name="country_code" onchange="getFlagImg(this)"
                                                data-search="true" class="form-control" style="width:30%">
                                                @foreach ($countryWithFlags as $country)
                                                    <option data-source="{{ $country->flag }}" value="{{ $country->id }}"
                                                        @if ($country->id == old('country_code', $defaultCountry->id)) selected @endif>
                                                        {{ $country->name }} ({{ $country->phone }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input id="phone" name="phone" value="{{ old('phone',$user?->phone) }}" type="number"
                                            class="form-control @error('phone') border-theme-6 @enderror"
                                            onKeyPress="if(this.value.length==11) return false;" required>

                                    </div>

                                    @error('country_code')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                    @error('phone')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                     

                        <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-8 mt-0">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="role" class="form-label sm:w-32">Role <span
                                        class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <select id="role_id" name="role_id" data-search="true"
                                        class="form-control w-full @error('role_id') border-theme-6 @enderror">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                @if ($role->id == old('role_id', $user->roles?->first()?->id)) selected @endif>{{ ucwords($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('role_id')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                <label for="url" class="form-label sm:w-32">Website Url <span
                                        class="text-theme-6">*</span></label>
                                <div class="sm:w-5/6">
                                    <input id="url" name="url" type="text"
                                        class="form-control @error('url') border-theme-6 @enderror"
                                        value="{{ old('url') }}" required>

                                    @error('url')
                                        <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>

                        <div class="text-right mt-5">
                            <a id="UserCancel" href="{{ route('dashboard.international-transfer.agent-detail',$user?->id) }}"
                                class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                            <button id="UserSubmit" type="submit" class="btn btn-primary w-24">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

        });

        function formatStateTwo(state) {
            if (!state.id) {
                return state.text;
            }

            var $state = $(
                '<span ><img  src="' + state.element.getAttribute('data-source') + '" /> ' + state.text + '</span>'
            );
            return $state;
        }

        function getFlagImg(the) {
            var img = $('option:selected', the).attr('data-source');
            $('#countryWithPhoneFlagImg').html('<img src="' + img + '">');
        }
    </script>
@endpush
