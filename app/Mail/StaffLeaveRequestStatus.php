<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffLeaveRequestStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $leave_request;
    public $updated_by;
 
    public function __construct($leave_request, $updated_by)
    {
        $this->leave_request = $leave_request;
        $this->updated_by = $updated_by;
    }
    
  
    public function build()
    {
        return $this
                ->subject('New Leave Request Notification')
                ->view('emails.leave.staff_leave_request_status')
                ->with([
                    'data' => $this->leave_request,
                    'updated_by' => $this->updated_by,
                ]);
    }
 
}
