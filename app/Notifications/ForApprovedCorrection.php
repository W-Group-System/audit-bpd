<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ForApprovedCorrection extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $corrective_action_request;
    protected $correction_action_date;
    protected $corrective_action_date;
    public function __construct($corrective_action_request,$correction_action_date,$corrective_action_date)
    {
        $this->corrective_action_request = $corrective_action_request;
        $this->correction_action_date = $correction_action_date;
        $this->corrective_action_date = $corrective_action_date;
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
                    ->subject('For Approved Correction and Corrective Action Implementation')
                    ->greeting('Good day,')
                    ->line('**CAR Number:** ' . 'CAR-'.str_pad($this->corrective_action_request->id,3,'0',STR_PAD_LEFT))
                    ->line('**Correction Action Date:** '. implode(", ", $this->correction_action_date))
                    ->line('**Corrective Action Date:** '. implode(", ", $this->corrective_action_date))
                    ->line('**Department:** '. $this->corrective_action_request->department->name)
                    ->line('**Auditee:** '. $this->corrective_action_request->auditee->name)
                    ->line('**Auditor:** '. $this->corrective_action_request->auditor->name)
                    ->line('Please click the button provided for faster transaction')
                    ->action('Corrective Action Request', url('corrective-action-request'))
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
