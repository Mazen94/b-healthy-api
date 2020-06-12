<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $firstName;
    public $lastName;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param $firstName
     * @param $lastName
     * @param $password
     */
    public function __construct($firstName, $lastName, $password)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('messages.welcome'))->markdown('emails.patientCreated');
    }
}
