<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffLeaveRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $leave_request;
    public $user;
    public $leave_type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($leave_request, $user, $leave_type)
    {
        $this->leave_request = $leave_request;
        $this->user = $user;
        $this->leave_type = $leave_type;
    }

     /** 
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject('New Leave Request Notification')
                ->view('emails.leave.staff_leave_request')
                ->with([
                    'data' => $this->leave_request,
                    'user' => $this->user,
                    'leave_type' => $this->leave_type,
                ]);
    }
}
