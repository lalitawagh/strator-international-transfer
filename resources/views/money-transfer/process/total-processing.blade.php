@section('money-transfer-content')
    <script src="{{ $url }}"></script>
    <div class="px-5 sm:px-20 mt-3 pt-3 sm:mt-10 sm:pt-10 border-t border-gray-200">
        <div class="intro-y mt-0 p-3">
            <div class="grid grid-cols-12 rounded-lg m-auto p-0 ">
                <div class="col-span-12 md:col-span-8 mony-transfer m-auto">
                    <form action="{{ route('dashboard.international-transfer.total-processing.status') }}"
                        class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
                </div>
            </div>
        </div>
    </div>
@endsection
