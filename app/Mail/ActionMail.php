<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $context;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($context)
    {
        $this->context = $context;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->context->subject)->view('client.mail.action');
    }
}
