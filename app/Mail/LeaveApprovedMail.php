<?php

namespace App\Mail;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;
    public $employee;

    public function __construct(LeaveRequest $leave)
    {
        $this->leave = $leave;
        $this->employee = $leave->employee;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Leave Request Approved - FutureWave',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.leave-approved',
        );
    }
}