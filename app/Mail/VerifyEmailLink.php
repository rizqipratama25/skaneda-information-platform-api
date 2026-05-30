<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmailLink extends Mailable implements ShouldQueue
{
    public int $tries = 3;
    public int $timeout = 10;

    public function __construct(
        public User $user,
        public string $verifyUrl
    ) {}

    public function build()
    {
        return $this->subject('Verifikasi Email Anda')
            ->view('emails.verify-email')
            ->with([
                'user'      => $this->user,
                'verifyUrl' => $this->verifyUrl,
            ]);
    }
}
