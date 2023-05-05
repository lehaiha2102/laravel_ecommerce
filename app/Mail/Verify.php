<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Verify extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $token;

    public function __construct($user)
    {
        $this->email = $user['email'];
        $this->token = $user['token'];
    }

    public function build()
    {
        return $this->from('your-email@example.com')
        ->view('emails.mail');
    }
}
