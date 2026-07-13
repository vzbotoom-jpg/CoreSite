<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct($user, $token = null)
    {
        // If constructed with token only (e.g. AuthController), handle that gracefully
        if (is_string($user) && is_null($token)) {
            $this->token = $user;
            $this->user = null;
        } else {
            $this->user = $user;
            $this->token = $token;
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Link',
        );
    }

    public function content(): Content
    {
        $resetUrl = url('/reset-password/' . $this->token);
        if ($this->user && isset($this->user->email)) {
            $resetUrl .= '?email=' . urlencode($this->user->email);
        }
        return new Content(
            html: '<h3>Reset Password</h3><p>Click the link below to reset your password:</p><p><a href="' . $resetUrl . '">Reset Password</a></p>',
        );
    }
}
