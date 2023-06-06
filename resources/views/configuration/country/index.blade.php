@extends('international-transfer::configuration.skeleton')

@section('title', 'Update Country currency')

@section('config-content')
    <div class="p-5">
        @if (Session::has('error'))
            <span class="block text-theme-6">{{ Session::get('error') }}</span>
        @endif
        <form action="{{ route('dashboard.international-transfer.country.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                    <label for="sendingcurrency" class="form-label sm:w-33">Sending Currency <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <select name="Sending_currency" id="Sending_currency" data-search="true"
                            class="w-full @error('Sending_currency') border-theme-6 @enderror" required>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @if (old('currency') == $country->id) selected @endif>
                                    {{ $country->currency }} ({{ $country->code }})</option>
                            @endforeach
                        </select>

                        @error('Sending_currency')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                    <label for="Receiving_currency" class="form-label sm:w-33">Receiving Currency <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <select name="Receiving_currency" id="Receiving_currency" data-search="true"
                            class="w-full @error('Receiving_currency') border-theme-6 @enderror" required>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @if (old('currency') == $country->id) selected @endif>
                                    {{ $country->currency }} ({{ $country->code }})</option>
                            @endforeach
                        </select>

                        @error('Receiving_currency')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-right mt-5">
                <a id="CountycurrencyCancel"  href="{{ route('dashboard.international-transfer.country.index') }}"
                    class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                <button id="TransferTypeSubmit" type="submit" class="btn btn-primary w-24">Update</button>
            </div>
        </form>
    </div>
@endsection
