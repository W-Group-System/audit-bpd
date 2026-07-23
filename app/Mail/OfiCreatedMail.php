<?php

namespace App\Mail;

use App\Ofi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfiCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ofi;

    public function __construct(Ofi $ofi)
    {
        $this->ofi = $ofi;
    }

    public function build()
    {
        return $this->subject('New Opportunity for Improvement (OFI)')
                    ->view('emails.ofi_created');
    }
}