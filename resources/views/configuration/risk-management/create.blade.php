@extends("international-transfer::configuration.skeleton")

@section('title', 'Risk Management')

@section('config-content')
    <div class="p-5">
        @if (Session::has('error'))
            <span class="block text-theme-6">{{ Session::get('error') }}</span>
        @endif
        <form action="{{ route('dashboard.international-transfer.risk-store-country') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
                <div class="col-span-12 md:col-span-8 lg:col-span-6 sm:col-span-8 form-inline mt-2">
                    <label for="high_risk_country" class="form-label sm:w-60">High Risk Country <span
                            class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6 tillselect-marging">
                        <select id="high_risk_country" name="high_risk_country[]" data-search="true"
                            class="w-full @error('high_risk_country') border-theme-6 @enderror" multiple>
                            @foreach ($countries as $key => $value)
                                <option value="{{ $key }}"
                                    @if (in_array($key, $highriskcountry)) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('high_risk_country')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-8 lg:col-span-6 sm:col-span-8 form-inline mt-2">
                    <label for="low_risk_country" class="form-label sm:w-60">Low Risk Country <span
                            class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6 tillselect-marging">
                        <select id="low_risk_country" name="low_risk_country[]" data-search="true"
                            class="w-full @error('low_risk_country') border-theme-6 @enderror" multiple>
                            @foreach ($countries as $key => $value)
                                <option value="{{ $key }}"
                                    @if (in_array($key, $lowriskcountry)) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('low_risk_country')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-right mt-5">
                <button type="submit" class="btn btn-primary w-24">Update </button>
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
