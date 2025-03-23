<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class digitActivationMail extends Mailable
{
    use Queueable, SerializesModels;
    private $codemail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $codemail)
    {
        $this->codemail = $codemail;
    }

    public function build()
    {
        return $this->from('noreply@example.com', 'Example App') // Configura el remitente aquí
                    ->view('emails.activate_account')
                    ->with('activationLink', $this->codemail);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Digit Activation Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.digit_activation',
            with: [
                'codemail' => $this->codemail
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
