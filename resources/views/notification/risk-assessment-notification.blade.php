@extends('cms::dashboard.components.mail')
@section('mail-content')
    <h3>Dear {{ $user->getFullName() }},</h3>
    <p>We regret to inform you that your payment is currently kept as pending for further verification.
        We kindly request you to click on the below link and fill in the additional information form.
        Once we get a response from your end, we will verify the details and release your payment.</p>
    @component('mail::button', ['url' => route('dashboard.riskAssessmentAdditionalInfoDetail', $user->id)])
        Click Here
    @endcomponent
    <p>
        Please do not reply directly to this email as it is a system-generated one.
        If you have any queries or need any help, please contact us at <a
            href="mailto:{{ config('services.support_mail') }} ">{{ config('services.support_mail') }} </a>. </p>
    <p>Thank you for your cooperation and understanding.</p>
@endsection
