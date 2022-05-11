@extends("international-transfer::configuration.skeleton")

@section('title', 'Create Transfer Type Fee')

@section('config-content')
    <div class="p-5">
        <form action="{{ route('dashboard.international-transfer.transfer-type-fee.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-12 md:gap-3 mt-0">
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                    <label for="currency" class="form-label sm:w-30">Currency <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <select name="currency" id="currency" data-search="true" class="tail-select w-full @error('currency') border-theme-6 @enderror" required>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @if (old('currency') == $country->id) selected @endif> {{  $country->currency }} ({{ $country->code }})</option>
                            @endforeach
                        </select>

                        @error('country')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                    <label for="type" class="form-label sm:w-30">Type <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">

                        <select name="type" id="type" onchange="getType(this)" data-search="true" class="tail-select w-full @error('status') border-theme-6 @enderror" required>
                            <option>Select Type</option>
                            @foreach ($fee_types as $fee_type)
                                @if ($fee_type == 'payment_type' || $fee_type == 'transfer_type')
                                    <option value="{{ $fee_type }}" @if (old('type') == $fee_type) selected @endif> {{  trans('international-transfer::configuration.'.$fee_type) }}</option>
                                @endif
                            @endforeach
                        </select>

                        @error('type')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-12 md:gap-3 mt-0">
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2 paymentType @if (old('type') == 'payment_type') active @else hidden @endif ">
                    <label for="payment_type" class="form-label sm:w-30">Payment Type <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input type="text" name="payment_type" id="payment_type" class="form-control" value="{{ old('payment_type') }}">

                        @error('payment_type')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2 transferType @if (old('type') == 'transfer_type') active @else hidden @endif">
                    <label for="transfer_type" class="form-label sm:w-30">Transfer Type <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input type="text" name="transfer_type" id="transfer_type" class="form-control"  value="{{ old('transfer_type') }}">

                        @error('transfer_type')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 md:gap-3 mt-0 sm:mb-0 mb-2">
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                    <label for="min_amount" class="form-label sm:w-30">Min Amount <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="min_amount" name="min_amount" type="text" class="form-control @error('min_amount') border-theme-6 @enderror" value="{{ old('min_amount') }}" required>

                        @error('min_amount')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                    <label for="max_amount" class="form-label sm:w-30">Max Amount <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="max_amount" name="max_amount" type="text" class="form-control @error('max_amount') border-theme-6 @enderror" value="{{ old('max_amount') }}" required>

                        @error('max_amount')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-12 md:gap-3 mt-0">
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-0">
                    <label for="status" class="form-label sm:w-30">Status <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <select name="status" id="status" data-search="true" class="tail-select w-full @error('status') border-theme-6 @enderror" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @if (old('status') == $status) selected @endif> {{ ucfirst($status) }} </option>
                            @endforeach
                        </select>

                        @error('status')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2" style="align-items: inherit;">
                    <label for="amount" class="form-label sm:w-30">Description </label>
                    <div class="sm:w-5/6">
                        <textarea name="description" rows="3" class="form-control resize-none">{{ old('description') }}</textarea>

                        @error('description')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-12 md:gap-3 mt-0" @if (old('fee_type') == 'amount') x-data="{ selected: '1' }" @elseif (old('fee_type') == 'percentage') x-data="{ selected: '0' }" @else x-data="{ selected: '3' }" @endif>
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-0">
                    <label for="amount" class="form-label sm:w-30">Fee <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6 sm:pt-1" >
                        <div class="form-check mr-2">
                            <input id="radio-switch-1" class="form-check-input" type="radio" x-on:click="selected = '1'" name="fee_type" value="amount" @if (old('fee_type') == 'amount') checked @endif>
                            <label class="form-check-label" for="radio-switch-1"><h4 href="javascript:;" class="font-medium truncate mr-5 " >
                                <h4>Amount</h4></label>
                            <input id="radio-switch-2" class="form-check-input ml-3" type="radio"   x-on:click="selected = '0'" name="fee_type" value="percentage" @if (old('fee_type') == 'percentage') checked @endif>
                            <label class="form-check-label" for="radio-switch-2"><h4 href="javascript:;" class="font-medium truncate mr-5">
                                <h4>Percentage</h4></label>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2" x-show="selected == '1'" >
                    <label for="amount" class="form-label sm:w-30">Amount <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="amount" name="amount" type="text" class="form-control @error('amount') border-theme-6 @enderror amount" value="{{ old('amount') }}">

                        @error('amount')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2" x-show="selected == '0'">
                    <label for="percentage" class="form-label sm:w-30">Percentage <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <div class="input-group">
                            <input id="percentage" name="percentage" type="text" class="form-control @error('percentage') border-theme-6 @enderror percentage" value="{{ old('percentage') }}">
                            <div id="input-group-percentage" class="input-group-text">%</div>
                        </div>

                        @error('percentage')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <a href="{{ route('dashboard.international-transfer.transfer-type-fee.index') }}"
                    class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                <button type="submit" class="btn btn-primary w-24">Create</button>
            </div>
        </form>
    </div>
@endsection


@push('scripts')
    <script>
        function getType(the)
        {
            var type = $(the).val();
            if(type == 'payment_type')
            {
                $('.paymentType').addClass('active');
                $('.transferType').addClass('hidden');
                $('.transferType').removeClass('active');
                $('.paymentType').removeClass('hidden');
            }
            else if(type == 'transfer_type')
            {
                $('.paymentType').addClass('hidden');
                $('.paymentType').removeClass('active');
                $('.transferType').removeClass('hidden');
                $('.transferType').addClass('active');
            }
        }
    </script>
@endpush
