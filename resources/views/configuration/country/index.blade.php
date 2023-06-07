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
                    <label for="sending_currency" class="form-label sm:w-33">Sending Currency <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <select name="sending_currency[]" id="sending_currency" data-search="true"
                            class="w-full @error('sending_currency') border-theme-6 @enderror" multiple>
                            @foreach ($countries as $country)
                            <option value="{{ $country->id }}"  @isset($sendingCurrency)
                            @if (in_array($country->id, $sendingCurrency)) selected @endif @endisset>
                                    {{ $country->currency }} ({{ $country->code }}) {{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('sending_currency')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                    <label for="receiving_currency" class="form-label sm:w-33">Receiving Currency <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <select name="receiving_currency[]" id="receiving_currency" data-search="true"
                            class="w-full @error('receiving_currency') border-theme-6 @enderror" multiple>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @isset($receivingCurrency)
                                @if (in_array($country->id, $receivingCurrency)) selected @endif @endisset>
                                    {{ $country->currency }} ({{ $country->code }}) {{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('receiving_currency')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-right mt-5">
                <a id="CountrycurrencyCancel"  href="{{ route('dashboard.international-transfer.country.index') }}"
                    class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                <button id="CountrycurrencySubmit" type="submit" class="btn btn-primary w-24">Update</button>
            </div>
        </form>
    </div>
@endsection
