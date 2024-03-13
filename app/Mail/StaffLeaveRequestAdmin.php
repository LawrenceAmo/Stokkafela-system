<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffLeaveRequestAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $leave_request;
    public $user;
    public $manager;
    public $leave_type;

    /**
     * Create a new message instance.
     *
     * @return void
     */ 
    public function __construct($leave_request, $user, $manager, $leave_type)
    {
        $this->leave_request = $leave_request;
        $this->user = $user;
        $this->manager = $manager;
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
                ->view('emails.leave.staff_leave_request_admin')
                ->with([
                    'data' => $this->leave_request,
                    'user' => $this->user,
                    'manager' => $this->manager,
                    'leave_type' => $this->leave_type,
                ]);
    }
}
