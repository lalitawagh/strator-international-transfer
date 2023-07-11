@extends('international-transfer::configuration.skeleton')

@section('title', 'Update Balances Country')

@section('config-content')
    <div class="p-5">
        @if (Session::has('error'))
            <span class="block text-theme-6">{{ Session::get('error') }}</span>
        @endif
        <form action="{{ route('dashboard.international-transfer.balances-country.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                    <label for="balance_country" class="form-label sm:w-40">Balances Country <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <select name="balance_country[]" id="balance_country" data-search="true"
                            class="w-full @error('balance_country') border-theme-6 @enderror" multiple>
                            @foreach ($countries as $country)
                            <option value="{{ $country->id }}"  @isset($balance_country)
                            @if (in_array($country->id, $balance_country)) selected @endif @endisset>
                                    {{ $country->currency }} ({{ $country->code }}) {{ $country->name }}</option>
                            @endforeach
                        </select>
                        
                        @error('balance_country')
                            <span class="text-theme-6">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-right mt-5">
                <a id="balancescountryCancel"  href="{{ route('dashboard.international-transfer.balances-country.index') }}"
                    class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                <button id="balancescountrySubmit" type="submit" class="btn btn-primary w-24">Update</button>
            </div>
        </form>
    </div>
@endsection
