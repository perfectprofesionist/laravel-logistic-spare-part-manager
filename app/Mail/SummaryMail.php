<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $summary;
    public $interests;
    public $additionalData;

    public function __construct($summary, $interests, $additionalData)
    {
        $this->summary = $summary;
        $this->interests = $interests;
        $this->additionalData = $additionalData;
    }

    public function build()
    {
        return $this->view('emails.summary')
                    ->subject('Your Quote Summary')
                    ->with([
                        'summary' => $this->summary,
                        'interests' => $this->interests,
                        'additionalData' => $this->additionalData
                    ]);
    }
}
