@push('styles')
    <style>
        .wpwl-wrapper.wpwl-wrapper-brand {
            width: 52%;
        }
    </style>
@endpush
@extends('international-transfer::money-transfer.process.wizard-skeleton')

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
    <script>
        var wpwlOptions = {
            style: "card",

            onReady: function(e) {
                $('.wpwl-form-card').find('.wpwl-button-pay').on('click', function(e) {
                    validateHolder(e);
                    validateExpiry(e);
                    validateCvv(e);
                    validateCard(e);
                });
            },
            onBeforeSubmitCard: function(e) {
                return validateHolder(e);
            }

        }

        function validateHolder(e) {
            var holder = $('.wpwl-control-cardHolder').val();
            if (holder.trim().length < 2) {
                $('.wpwl-control-cardHolder').addClass('wpwl-has-error').after(
                    '<div class="wpwl-hint wpwl-hint-cardHolderError">Please enter card holder</div>');
                return false;
            }
            return true;
        }

        function validateCard(e) {
            var holder = $('.wpwl-control-cardNumber').val();
            if (holder.trim().length < 2) {
                $('.wpwl-control-cardNumber').addClass('wpwl-has-error').after(
                    '<div class="wpwl-hint wpwl-hint-cardNumberError">Please enter card number</div>');
                return false;
            }
            return true;
        }

        function validateExpiry(e) {
            var holder = $('.wpwl-control-expiry').val();
            if (holder.trim().length < 2) {
                $('.wpwl-control-expiry').addClass('wpwl-has-error').after(
                    '<div class="wpwl-hint wpwl-hint-expiryMonthError">Please enter expiry date</div>');
                return false;
            }
            return true;
        }

        function validateCvv(e) {
            var holder = $('.wpwl-control-cvv').val();
            if (holder.trim().length < 2) {
                $('.wpwl-control-cvv').addClass('wpwl-has-error').after(
                    '<div class="wpwl-hint wpwl-hint-cvvError">Please enter CVV</div>');
                return false;
            }
            return true;
        }
    </script>
@endsection
€
