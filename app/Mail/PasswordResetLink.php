<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetLink extends Mailable
{
    use Queueable, SerializesModels;
    public $link;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $user)
    {
        //
        $this->subject('Alfanet - Şifre Sıfırlama Epostası');
        $this->link = $link;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reset-password-link');
    }
}
