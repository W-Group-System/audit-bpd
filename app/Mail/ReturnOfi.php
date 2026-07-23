<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReturnOfi extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $ofi_request;
    protected $remarks;
    public function __construct($ofi_request, $remarks)
    {
        $this->ofi_request = $ofi_request;
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
            ->view('emails.return_ofi_email', array('ofi' => $this->ofi_request, 'remarks' => $this->remarks));
    }
}
