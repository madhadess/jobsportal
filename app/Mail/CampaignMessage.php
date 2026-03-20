<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $messageText;
    public $recipientName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $messageText, $recipientName)
    {
        $this->subject = $subject;
        $this->messageText = $messageText;
        $this->recipientName = $recipientName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
            ->subject($this->subject)
            ->view('emails.campaign');
    }
}
