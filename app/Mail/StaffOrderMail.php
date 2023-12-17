<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user_info;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_info, $order)
    {
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
                ->view('emails.staff_order')
                ->with([
                    'name' => $this->user_info,
                    'order' => $this->order,
                    // other variables you want to pass to the email view
                ]);

    }

    // /**
    //  * Get the message envelope.
    //  *
    //  * @return \Illuminate\Mail\Mailables\Envelope
    //  */
    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: 'Staff Order Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  *
    //  * @return \Illuminate\Mail\Mailables\Content
    //  */
    // public function content()
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array
    //  */
    // public function attachments()
    // {
    //     return [];
    // }
}
