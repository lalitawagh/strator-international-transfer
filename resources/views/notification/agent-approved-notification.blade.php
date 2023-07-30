@extends('cms::dashboard.components.mail')
@section('mail-content')
    <h3>Dear {{ $user->getFullName() }},</h3>
    <p>We are excited to inform you that your Agent Account with us has been successfully created and approved by our administration team. 
        Congratulations on taking this important step towards growing your business!
        </p>
    <p>Please find below your Agent ID:</p>
    <p>Agent ID : {{ $membership->urn}}</p>
    <p>
        Keep this information safe as it will be required for any future communication with us. 
        If you have any questions or require further assistance, please don't hesitate to contact our team.
        We are excited about this journey together and look forward to witnessing the success of your business.</p>
    <p>Please do not reply directly to this email as it is a system-generated one.
        If you have any queries or need any help, please contact us at <a
            href="mailto:{{ config('services.support_mail') }} ">{{ config('services.support_mail') }} </a>. </p>
    <p>Thank you for your cooperation and understanding.</p>
@endsection