@extends('cms::dashboard.components.mail')
@section('mail-content')
    <h1>Hi @isset($user) {{ $user->getFullName() }},  @else {{ @$workspace->name }}, @endisset</h1>
    <p>We regret to inform you that your money transfer request is done.
        Please deposit money in your Sub Account for further process.</p>
@endsection
