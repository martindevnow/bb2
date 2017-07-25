<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $contactFormFields;

    /**
     * Create a new message instance.
     *
     * @param $contactFormFields
     */
    public function __construct($contactFormFields)
    {
        $this->contactFormFields = $contactFormFields;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@barfbento.com')
            ->view('emails.contact.received')
            ->with(['contact' => $this->contactFormFields]);
    }
}
