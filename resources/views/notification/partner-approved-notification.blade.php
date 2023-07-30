@extends('cms::dashboard.components.mail')
@section('mail-content')
    <h3>Dear {{ $user->getFullName() }},</h3>
    <p>We are excited to inform you that your Partner Account with us has been successfully created and approved by our administration team. 
        Congratulations on taking this important step towards growing your business!
        To get started, we have assigned you a unique Client ID Key, which will serve as your identification when accessing our platform.</p>
    <p>Please find below your Client ID Key:</p>
    <p>Client ID Key: {{ $client_id}}</p>
    <p>
        Keep this information safe as it will be required for any future communication with us. 
        If you have any questions or require further assistance, please don't hesitate to contact our team.
        Once again, congratulations on becoming a valued partner with us. We are excited about this journey together and look forward to witnessing the success of your business.</p>
    <p>Please do not reply directly to this email as it is a system-generated one.
        If you have any queries or need any help, please contact us at <a
            href="mailto:{{ config('services.support_mail') }} ">{{ config('services.support_mail') }} </a>. </p>
    <p>Thank you for your cooperation and understanding.</p>
@endsection
