@extends("international-transfer::configuration.skeleton")

@section('title', 'Edit Fee')

@section('config-content')
    <div class="p-5">
        <form action="{{ route('dashboard.international-transfer.fee.update',$fee['id']) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-12 md:gap-10 mt-0">
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="type" class="form-label sm:w-30">Type <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <select name="type" id="type" data-search="true" class="tail-select w-full @error('status') border-theme-6 @enderror" required>
                            @foreach ($fee_types as $fee_type)
                                @if ($fee_type != \Kanexy\InternationalTransfer\Enums\Fee::PAYMENT_TYPE && $fee_type != \Kanexy\InternationalTransfer\Enums\Fee::TRANSFER_TYPE)
                                    <option value="{{ $fee_type }}" @if ($fee['type'] == $fee_type) selected @endif> {{  trans('international-transfer::configuration.'.$fee_type) }}</option>
                                @endif
                            @endforeach
                        </select>

                        @error('type')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="status" class="form-label sm:w-30">Status <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <select name="status" id="status" data-search="true" class="tail-select w-full @error('status') border-theme-6 @enderror" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @if ($fee['status'] == $status) selected @endif> {{ ucfirst($status) }} </option>
                            @endforeach
                        </select>

                        @error('status')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 md:gap-10 mt-0">
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="min_amount" class="form-label sm:w-30">Min Amount <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="min_amount" name="min_amount" type="text" class="form-control @error('min_amount') border-theme-6 @enderror" value="{{ old('min_amount',$fee['min_amount']) }}" required>

                        @error('min_amount')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="max_amount" class="form-label sm:w-30">Max Amount <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="max_amount" name="max_amount" type="text" class="form-control @error('max_amount') border-theme-6 @enderror" value="{{ old('max_amount',$fee['max_amount']) }}" required>

                        @error('max_amount')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 md:gap-10 mt-0">
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="amount" class="form-label sm:w-30">Amount </label>
                    <div class="sm:w-5/6">
                        <input id="amount" name="amount" type="text" class="form-control @error('amount') border-theme-6 @enderror" value="{{ old('amount',$fee['amount']) }}">

                        @error('amount')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="percentage" class="form-label sm:w-30">Percentage </label>
                    <div class="sm:w-5/6">
                        <div class="input-group">
                            <input id="percentage" name="percentage" type="text" class="form-control @error('percentage') border-theme-6 @enderror" value="{{ old('percentage',$fee['percentage']) }}">
                            <div id="input-group-percentage" class="input-group-text">%</div>
                        </div>

                        @error('percentage')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <a href="{{ route('dashboard.international-transfer.fee.index') }}"
                    class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                <button type="submit" class="btn btn-primary w-24">Update</button>
            </div>
        </form>
    </div>
@endsection
