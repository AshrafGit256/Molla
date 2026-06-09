<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->subject('Test Mailtrap Email')
                    ->view('emails.test')
                    ->with([
                        'title' => $this->details['title'] ?? 'Test Email',
                        'body' => $this->details['body'] ?? 'This is a test email from your Laravel application.',
                    ]);
    }
}
