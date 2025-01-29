<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InstaFollowersVericationInfoMail extends Mailable
{
    use Queueable, SerializesModels;

   public $data;
    public function __construct($data)
    {
       $this->data=$data;
    }

    public function build()
    {
        return $this->subject('Instagram Followers Verification Information')
        ->view('admin.auth.insta-followers-verify-info')
        ->with('data', $this->data);
    }
}
