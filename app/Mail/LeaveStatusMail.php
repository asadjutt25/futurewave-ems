<?php
// app/Mail/LeaveStatusMail.php

namespace App\Mail;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;
    public $status;

    public function __construct(Leave $leave, $status)
    {
        $this->leave = $leave;
        $this->status = $status;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Leave Application ' . ucfirst($this->status) . ' - FutureWave EMS',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.leave-status',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}