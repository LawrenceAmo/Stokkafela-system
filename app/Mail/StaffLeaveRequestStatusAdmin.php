<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffLeaveRequestStatusAdmin extends Mailable
{
    use Queueable, SerializesModels;
 
    public $leave_request;
 
    public function __construct($leave_request)
    {
        $this->leave_request = $leave_request;
    }
    
  
    public function build()
    {
        return $this
                ->subject('New Leave Request Notification')
                ->view('emails.leave.staff_leave_request_status_admin')
                ->with([
                    'data' => $this->leave_request,
                ]);
    }
}
