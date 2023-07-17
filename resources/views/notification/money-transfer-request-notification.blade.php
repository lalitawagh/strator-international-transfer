@extends('cms::dashboard.components.mail')
@section('mail-content')
    <h1>Dear @isset($user) {{ $user->getFullName() }},  @else {{ @$workspace->name }}, @endisset</h1>
    <p>We're confirm that we are now processing your transfer.</p>
    <p> Account Name :- {{ ucwords(@$account->meta['account_holder_name']) }} <br>
        Payment Amount :- {{ @$transaction->meta['recipient_amount'] }} <br>
        Payment Currency :- {{ @$transaction->meta['exchange_currency'] }} <br>
        Payment Reference :- {{ @$transaction->meta['reference_no'] }} <br>
        Payment Date :- {{ @$transaction->created_at }} <br>
        Beneficiary Name :- {{ @$transaction->meta['second_beneficiary_name'] }} <br>
        Beneficiary Account No :- {{ @$transaction->meta['second_beneficiary_bank_account_number'] }} <br>
        IFSC Code :- {{ @$transaction->meta['second_beneficiary_bank_iban'] }} <br>
    </p>
@endsection
