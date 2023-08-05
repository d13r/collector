<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class CollectorMessage extends Mailable
{
    use Queueable, SerializesModels;

    public string $mySubject; // $subject is used by the parent class
    public string $body;

    public function __construct(
        private array $target,
        private string $message,
    )
    {
        // The first line is the subject, the rest is the body
        $message = str_replace(["\r\n", "\r"], "\n", $message);

        $parts = explode("\n", $message, 2);

        if (count($parts) === 1) {
            $this->mySubject = $message;
            $this->body = '';
        } else {
            $this->mySubject = trim($parts[0]);
            $this->body = trim($parts[1]);
        }
    }

    public function envelope(): Envelope
    {
        $envelope = new Envelope();
        $envelope->subject($this->mySubject);
        $envelope->from(...$this->target['from']);

        foreach ($this->target['to'] as $to) {
            $envelope->to(...$to);
        }

        foreach ($this->target['replyto'] ?? [] as $replyTo) {
            $envelope->replyTo(...$replyTo);
        }

        if ($this->target['return'] ?? false) {
            $envelope->using(function (Email $email) {
                $email->returnPath($this->target['return']);
            });
        }

        return $envelope;
    }

    public function content(): Content
    {
        return new Content(
            text: 'mail.message-text',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
