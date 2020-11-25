<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmailCreateAccount extends Mailable
{
    use Queueable, SerializesModels;
    public $user, $link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->subject('Alfanet - Hesap Aktivasyon Epostası');
        $this->user = $user;
        $this->link = config('app.url').'/verify-account/'.$user->email_verification_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verify-demo-account');
    }
}
