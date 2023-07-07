<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageToFactory extends Mailable
{
    use Queueable, SerializesModels;

    public $data;       // Accessible from every method, using $this->data

    /**
     * Create a new message instance using New new MessageToFactory($data).
     *
     * @return void
     */
    public function __construct($data=null)
    {
        $this->$data = $data;   // Assign data to the public vairable $data
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Laravel e-mail to Factory')->view('mail.messagetofactory', ["data"=>$this->data]);
    }
}
