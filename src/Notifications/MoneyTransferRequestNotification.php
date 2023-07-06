<?php

namespace Kanexy\InternationalTransfer\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Models\CcAccount;

class MoneyTransferRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$workpsace,$transaction)
    {
        $this->user = $user;
        $this->workspace = $workpsace;
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $senderMail = Setting::getValue('sender_mail',[]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        $account = CcAccount::where(['holder_id' => $workspace?->id])->first();

        return (new MailMessage)->subject('Deposit Money in Sub Account')
                    ->from($senderMail, config('mail.from.name'))
                    ->markdown('international-transfer::notification.money-transfer-request-notification', ['user' => $this->user, 'workspace' => $this->workspace, 'account' => $account, 'transaction' => $this->transaction]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {

        return [
            'message' => Carbon::now(),
            'user' => $notifiable,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
