@extends('international-transfer::money-transfer.process.wizard-skeleton')

@section('custom_js_scripts')
    <script src="https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $checkoutId }}">
    </script>
@endsection

@section('money-transfer-content')
    <div class="px-5 sm:px-20 mt-3 pt-3 sm:mt-10 sm:pt-10 border-t border-gray-200">
        <div class="intro-y mt-0 p-3">
            <div class="grid grid-cols-12 rounded-lg m-auto p-0 ">
                <div class="col-span-12 md:col-span-8 mony-transfer m-auto">

                    <form action="{{ route('dashboard.international-transfer.money-transfer.showFinal', ['filter' => ['workspace_id' => $transferDetails['workspace_id']]]) }}" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
                </div>
            </div>
        </div>

    </div>
@endsection
