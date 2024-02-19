<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class NewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $newPassword;
    public $loginLink;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $user
     * @param  string  $newPassword
     * @return void
     */
    public function __construct($user, $newPassword, $loginLink)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
        $this->loginLink = $loginLink; 
    }
    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $loginUrl = $this->loginLink;
        
        return $this->subject('New User Registration')
                    ->view('emails.welcome-email', compact('loginUrl'));
    }
}
