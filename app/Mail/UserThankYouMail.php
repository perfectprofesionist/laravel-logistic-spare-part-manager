<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->subject('Thank You for Your Inquiry')
                    ->view('emails.user_thank_you');
    }
}


