<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyMail extends Mailable
{
    use Queueable, SerializesModels;

    // protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  $this->name = $name;
    }

    /** 
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this  //->from('info@effectivewing.com')
                ->subject('Welcome to Mabebeza')
                ->view('emails.welcome')
                ->with([
                    // 'name' => $this->name,
                    // other variables you want to pass to the email view
                ]);

    }
}
