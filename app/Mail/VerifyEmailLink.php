<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VerifyEmailLink extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $verifyUrl) {}

    public function build()
    {
        return $this->subject('Verify your email')
                    ->view('emails.verify-email')
                    ->with([
                        'user'      => $this->user,
                        'verifyUrl' => $this->verifyUrl,
                    ]);
    }
}
