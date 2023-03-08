<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta charset="utf-8">
      <!-- utf-8 works for most cases -->
      <meta name="viewport" content="width=device-width">
      <title>Transfer Details</title>
   </head>
   <body width="100%" style="width: 100%; 0;font-family: 'Rubik', sans-serif; color:#444e5e;">
      <!-- Visually Hidden Preheader Text : BEGIN -->
      <div style="width:100%; margin: auto;font-family: box-shadow: 0px 3px 20px #0000000b; border-radius: 0.375rem;">
         <!-- Email Body : BEGIN -->
            @if(!$user->isSubscriber())
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="background-color: #fff; max-width: 6000px;">
                <!-- Hero Image, Flush : BEGIN -->
                <tbody>
                <tr style="padding-left: 2.5rem; padding-right: 2.5rem;">
                    <td bgcolor="#ffffff" style="padding:20px 20px; text-align: left; font-family: sans-serif; font-size: 16px; line-height: 26px; color: #666666;">
                        <img src="https://dev.kanexy.com/img/core-img/logo.png" width="13rem" height="" alt="alt_text" border="0"  class="fluid" style="width: 100%; max-width: 13rem; background: #fff; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    </td>
                    <td style="text-align:right;padding:20px 20px;font-family: 'Rubik', sans-serif">
                        <div class="lg:text-right mt-10 lg:mt-0 lg:ml-auto">
                            <div style="font-size: 1.5rem;line-height: 2rem; font-weight:600;">Transfer Details</div>
                            <div style="font-size: 1rem;line-height: 2rem; font-weight:500;"> Date: <span class="font-medium">{{ $transaction->created_at }}</span> </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            @endif
         @if($user->isSubscriber())
         <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="background-color: #fff; max-width: 6000px;">
            <!-- Hero Image, Flush : BEGIN -->
            <tbody>
            <tr style="padding-left: 2.5rem; padding-right: 2.5rem;">
                <td bgcolor="#ffffff" style="padding:20px 20px; text-align: left; font-family: sans-serif; font-size: 16px; line-height: 26px; color: #666666;">
                    <img src="https://dev.kanexy.com/img/core-img/logo.png" width="13rem" height="" alt="alt_text" border="0"  class="fluid" style="width: 100%; max-width: 13rem; background: #fff; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                </td>
                <td style="text-align:right;padding:20px 20px;font-family: 'Rubik', sans-serif">
                    <div class="lg:text-right mt-10 lg:mt-0 lg:ml-auto">
                        <div style="font-size: 1.5rem;line-height: 2rem; font-weight:600;">Transfer Details</div>
                        <div style="font-size: 1rem;line-height: 2rem; font-weight:500;"> Date: <span class="font-medium">{{ $transaction->created_at }}</span> </div>
                    </div>
                </td>
            </tr>
            <tr style="padding-left: 2.5rem; padding-left: 2.5rem;">
                <td style="text-align:left;padding:20px 20px;">
                    {{-- <div>
                        <div style="font-size: 1.5rem;line-height: 2rem; font-weight:600; padding-bottom:10px">Sender Name:&nbsp; {{ $account?->name }}</div>
                        <div style="font-size: 1rem;line-height:1.5; font-weight:500;">Account No:&nbsp; {{ $account?->account_number }}<br>
                            <div style="font-size: 1rem;line-height:1.5; font-weight:500;">Sort Code:&nbsp; {{ $account?->bank_code }}<br>
                        </div>
                    </div> --}}
                </td>
                <td style="text-align:right;padding:20px 20px;">
                    <div class="lg:text-right mt-10 lg:mt-0 lg:ml-auto">
                        <div style="font-size: 1.5rem;line-height: 2rem; font-weight:600; padding-bottom:10px">Receiver Name:&nbsp; {{ $transaction->meta['second_beneficiary_name'] }}</div>
                        <div style="font-size: 1rem;line-height: 1.5; font-weight:600;">Account Number:&nbsp; {{ $transaction->meta['second_beneficiary_bank_account_number']}}</div>
                        <div style="font-size: 1rem;line-height: 2rem; font-weight:500;">IFSC / IBAN Code:&nbsp; {{ $transaction->meta['second_beneficiary_bank_iban']}}</div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        @endif
         <h2 style="text-align: center">Transfer Details</h2>
        <table role="presentation" cellspacing="0" cellpadding="10" border="0" width="100%">
            <thead style="text-align:left; font-size: 16px;font-weight: 600;">
                <tr>
                    <th style="white-space: nowrap;">Transaction Id</th>
                    <th style="white-space: nowrap;">Created At</th>
                    <th style="white-space: nowrap;">Transfer Type</th>
                    <th style="white-space: nowrap;">Sending Currency</th>
                    <th style="white-space: nowrap;">Sending Amount</th>
                    <th style="white-space: nowrap;">Receiving Currency</th>
                    <th style="white-space: nowrap;">Receiving Amount</th>
                    <th style="white-space: nowrap;">Status</th>
                </tr>
            </thead>
            <tbody style="text-align:left; font-size: 20px;">

                    <tr style="border-top: 1px solid #f1f5f9;font-size: 16px;">
                        <td style="white-space: nowrap;">{{ $transaction?->urn }}</td>
                        <td style="white-space: nowrap;">{{ $transaction?->created_at }}</td>
                        <td style="white-space: nowrap;">{{ trans('international-transfer::configuration.' . $transaction?->payment_method) }}</td>
                        <td style="white-space: nowrap;">{{ @$transaction?->meta['base_currency'] }}</td>
                        <td style="white-space: nowrap;">{{ \Kanexy\PartnerFoundation\Core\Helper::getFormatAmount($transaction?->amount) }}</td>
                        <td style="white-space: nowrap;">{{ @$transaction?->meta['exchange_currency'] }}</td>
                        <td style="white-space: nowrap;">{{ @$transaction?->meta['recipient_amount'] }}</td></td>
                        <td style="white-space: nowrap;">{{ ucfirst($transaction?->status) }}</td>
                    </tr>

            </tbody>
        </table>
      </div>
   </body>
</html>
