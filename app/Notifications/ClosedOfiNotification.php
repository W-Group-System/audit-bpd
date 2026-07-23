<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ClosedOfiNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $ofi;
    public function __construct($ofi)
    {
        $this->ofi = $ofi;
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
        return (new MailMessage)
                    ->subject('Closed OFI')
                    ->greeting('Good day,')
                    ->line('Congratulations!')
                    ->line('**OFI Number:** '. ($this->ofi->ofi_no))
                    ->line('**Department:** '.$this->ofi->department->name)
                    ->line('**Auditee:** '.$this->ofi->issuedTo->name)
                    ->line('**Auditor:** '. $this->ofi->issuedBy->name)
                    ->action('Opportunity for Improvement', url('ofi'))
                    ->line('Thank you for using our application!');
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
