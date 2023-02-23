@extends('cms::dashboard.components.mail')
@section('mail-content')
    <h1> Hi {{ $user->getFullName() }},</h1>
    <p>Your payment is kept as pending review.We want to know some more info.Please click above link and fill additional info form. After get your reposne will verified and release your payment.
    </p>
    @component('mail::button', ['url' => route('dashboard.riskAssessmentAdditionalInfoDetail',$user->id)])
        Click Here
    @endcomponent
@endsection
