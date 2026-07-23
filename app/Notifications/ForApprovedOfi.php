<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ForApprovedOfi extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $ofi_request;
    protected $correction_action_date;
    public function __construct($ofi_request,$correction_action_date)
    {
        $this->ofi_request = $ofi_request;
        $this->correction_action_date = $correction_action_date;
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
                    ->subject('For Opportunity for Improvement')
                    ->greeting('Good day,')
                    ->line('**OFI Number:** ' . ($this->ofi_request->ofi_no))
                    ->line('**Implementation Date:** '. implode(", ", $this->correction_action_date))
                    ->line('**Department:** '. $this->ofi_request->department->name)
                    ->line('**Auditee:** '. $this->ofi_request->issuedTo->name)
                    ->line('**Auditor:** '. $this->ofi_request->issuedBy->name)
                    ->line('Please click the button provided for faster transaction')
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
