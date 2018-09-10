<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user_password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_password)
    {
        $this->user_password = $user_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mails.registration')->with([
            'password' => $this->user_password
        ]);
    }
}
