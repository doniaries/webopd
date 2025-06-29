<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The contact form data.
     *
     * @var array
     */
    public $formData;

    /**
     * Create a new message instance.
     *
     * @param  array  $formData
     * @return void
     */
    public function __construct(array $formData)
    {
        $this->formData = $formData;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        $appName = config('app.name');
        
        return new Envelope(
            subject: 'Pesan Baru dari Formulir Kontak - ' . $appName,
            from: config('mail.from.address', 'noreply@example.com'),
            replyTo: $this->formData['email']
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form',
            with: [
                'name' => $this->formData['name'],
                'email' => $this->formData['email'],
                'phone' => $this->formData['phone'],
                'subject' => $this->formData['subject'],
                'message' => $this->formData['message'],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
