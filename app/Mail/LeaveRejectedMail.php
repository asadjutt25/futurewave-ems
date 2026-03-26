<?php

namespace App\Mail;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;
    public $employee;
    public $remarks;

    public function __construct(LeaveRequest $leave, $remarks = null)
    {
        $this->leave = $leave;
        $this->employee = $leave->employee;
        $this->remarks = $remarks;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Leave Request Update - FutureWave',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.leave-rejected',
        );
    }
}