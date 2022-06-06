@extends("international-transfer::configuration.skeleton")

@section('title', 'Edit Transfer Reason')

@section('config-content')
    <div class="p-5">
        <form action="{{ route('dashboard.international-transfer.transfer-reason.update',$money_transfer_reason['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-12 md:gap-3 mt-0">
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mb-2">
                    <label for="reason" class="form-label sm:w-24">Type <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="reason" name="reason" type="reason" class="form-control @error('reason') border-theme-6 @enderror" value="{{ old('reason',$money_transfer_reason['reason']) }}" required>

                        @error('reason')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mb-2">
                    <label for="status" class="form-label sm:w-24">Status <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6 tillselect-marging">
                        <select name="status" id="status" data-search="true" class="tail-select w-full @error('status') border-theme-6 @enderror" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @if ($money_transfer_reason['status'] == $status) selected @endif> {{ ucfirst($status) }} </option>
                            @endforeach
                        </select>

                        @error('status')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <a href="{{ route('dashboard.international-transfer.transfer-reason.index') }}"
                    class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                <button type="submit" class="btn btn-primary w-24">Update</button>
            </div>
        </form>
    </div>
@endsection
