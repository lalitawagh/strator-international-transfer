@extends("international-transfer::configuration.skeleton")

@section('title', 'Money Transfer Collection Account Create')

@section('config-content')
    <div class="p-5">
        @if (Session::has('error'))
            <span class="block text-theme-6">{{ Session::get('error') }}</span>
        @endif
        <form action="{{ route('dashboard.international-transfer.master-account.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
                <div class="col-span-12 md:col-span-8 lg:col-span-6 sm:col-span-8 form-inline mt-2">
                    <label for="country" class="form-label sm:w-60">Country <span
                            class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6 tillselect-marging">
                        <select name="country" id="country" onchange="getCountry(this)" data-search="true"
                            class="w-full @error('country') border-theme-6 @enderror" required>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}"
                                    @if (old('country', 231) == $country->id) selected @endif> {{ $country->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('country')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-8 xl:col-span-6 form-inline mt-2">
                    <label for="status" class="form-label sm:w-60"> Status <span
                            class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6 tillselect-marging">
                        <select name="status" id="status" data-search="true" class="w-full">
                            <option value="">Select Status</option>
                            <option value="{{ \Kanexy\InternationalTransfer\Enums\Status::ACTIVE }}"
                                @if (old('status') === \Kanexy\InternationalTransfer\Enums\Status::ACTIVE) selected @endif>
                                {{ trans('international-transfer::configuration.active') }}</option>
                            <option value="{{ \Kanexy\InternationalTransfer\Enums\Status::INACTIVE }}"
                                @if (old('status') === \Kanexy\InternationalTransfer\Enums\Status::INACTIVE) selected @endif>
                                {{ trans('international-transfer::configuration.inactive') }}</option>
                        </select>

                        @error('status')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
                <div class="col-span-12 md:col-span-8 lg:col-span-6 sm:col-span-8 form-inline mt-2">
                    <label for="account_holder_name" class="form-label sm:w-60">Account Holder Name <span
                            class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="account_holder_name" name="account_holder_name" type="text"
                            class="form-control @error('account_holder_name') border-theme-6 @enderror"
                            value="{{ old('account_holder_name') }}" required>

                        @error('account_holder_name')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 md:col-span-8 lg:col-span-6 sm:col-span-8 form-inline mt-2">
                    <label for="account_branch" class="form-label sm:w-60">Account Branch <span
                            class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="account_branch" name="account_branch" type="text"
                            class="form-control @error('account_branch') border-theme-6 @enderror"
                            value="{{ old('account_branch') }}" required>

                        @error('account_branch')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
                <div class="col-span-12 md:col-span-8 lg:col-span-6 sm:col-span-8 form-inline mt-2">
                    <label for="account_number" class="form-label sm:w-60">Account Number <span
                            class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="account_number" name="account_number" type="text"
                            class="form-control @error('account_number') border-theme-6 @enderror"
                            value="{{ old('account_number') }}" required>

                        @error('account_number')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div id="sort_code"
                    class="col-span-12 md:col-span-8 lg:col-span-6 sm:col-span-8 form-inline mt-2">
                    <label for="sort_code" class="form-label sm:w-60">Sort Code <span
                            class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="sort_code" name="sort_code" type="text"
                            class="form-control @error('sort_code') border-theme-6 @enderror"
                            value="{{ old('sort_code') }}">

                        @error('sort_code')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div id="ifsc_code"
                    class="col-span-12 md:col-span-8 lg:col-span-6 sm:col-span-8 form-inline mt-2"
                    style="display: none;">
                    <label for="ifsc_code" class="form-label sm:w-60">IFSC Code <span
                            class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="ifsc_code" name="ifsc_code" type="text"
                            class="form-control @error('ifsc_code') border-theme-6 @enderror"
                            value="{{ old('ifsc_code') }}">

                        @error('ifsc_code')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>



            <div class="text-right mt-5">
                <a href="{{ route('dashboard.international-transfer.master-account.index') }}"
                    class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                <button type="submit" class="btn btn-primary w-24">Create</button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        function getCountry(the) {
            var country = $(the).val();
            if (country == 231) {
                $('#sort_code').css('display', 'flex');
                $('#ifsc_code').css('display', 'none');
            } else {
                $('#sort_code').css('display', 'none');
                $('#ifsc_code').css('display', 'flex');
            }
        }
    </script>
@endpush
