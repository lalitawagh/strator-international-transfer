@extends("international-transfer::configuration.skeleton")

@section('title', 'Money Transfer Collection Account')

@section('config-content')
    <div class="p-5">
        <form action="{{ route('dashboard.international-transfer.master-account.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-12 md:gap-10 mt-0">
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="account_holder_name" class="form-label sm:w-60">Account Holder Name <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="account_holder_name" name="account_holder_name" type="text" class="form-control @error('account_holder_name') border-theme-6 @enderror" value="{{ old('account_holder_name',@$account_details['account_holder_name']) }}" required>

                        @error('account_holder_name')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="account_branch" class="form-label sm:w-60">Account Branch <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="account_branch" name="account_branch" type="text" class="form-control @error('account_branch') border-theme-6 @enderror" value="{{ old('account_branch',@$account_details['account_branch']) }}" required>

                        @error('account_branch')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 md:gap-10 mt-0">
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="account_number" class="form-label sm:w-60">Account Number <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="account_number" name="account_number" type="text" class="form-control @error('account_number') border-theme-6 @enderror" value="{{ old('account_number',@$account_details['account_number']) }}" required>

                        @error('account_number')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="sort_code" class="form-label sm:w-60">Sort Code <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="sort_code" name="sort_code" type="text" class="form-control @error('sort_code') border-theme-6 @enderror" value="{{ old('sort_code',@$account_details['sort_code']) }}" required>

                        @error('sort_code')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <button type="submit" class="btn btn-primary w-24">Update</button>
            </div>
        </form>
    </div>
@endsection
