<x-mail::message>
    Dear {{ $user->first_name }} {{ $user->last_name }},
    <p>
        <br>
        <br>
        We are writing to inform you about a recent international transaction that occurred on your account.
        On {{ $transaction->created_at }}, a debit transaction was processed on your account in the amount of
        {{ $transaction->amount }} {{ $transaction->settled_currency }}.
        The transaction was converted to {{ $transaction->instructed_currency }} {{ $transaction->instructed_amount }}
        at a conversion rate of {{ $transaction->meta['exchange_rate'] }} and resulted in a total debit amount of
        {{ $transaction->meta['recipient_amount'] }}{{ $transaction->meta['base_currency'] }}.
        <br>
        <br>
        If you have any questions or concerns about this transaction, please do not hesitate to contact us at
        {{ env('SUPPORT_EMAIL') }}.
        <br>
        <br>
        Thank you for choosing our service.
    </p>
    Best regards,<br>
    {{ config('app.name') }}
</x-mail::message>
