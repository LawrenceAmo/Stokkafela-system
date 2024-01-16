<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffOrderAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user_info;
    public $admin_info;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin_info, $user_info, $order)
    {
        $this->admin_info = $admin_info;
        $this->user_info = $user_info;
        $this->order = $order;
    }

    /** 
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this  //->from('info@effectivewing.com')
                ->subject('Welcome to Stokkafela')
                ->view('emails.staff_order_admin')
                ->with([
                    'name' => $this->user_info,
                    'order' => $this->order,
                    // other variables you want to pass to the email view
                ]);

    }
}
