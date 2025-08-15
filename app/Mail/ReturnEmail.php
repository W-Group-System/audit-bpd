<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReturnEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $corrective_action_request;
    protected $remarks;
    public function __construct($corrective_action_request, $remarks)
    {
        $this->corrective_action_request = $corrective_action_request;
        $this->remarks = $remarks;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            // ->view('emails.return_email');
            ->view('emails.return_email', array('car' => $this->corrective_action_request, 'remarks' => $this->remarks));
    }
}
