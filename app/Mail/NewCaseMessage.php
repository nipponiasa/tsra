<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCaseMessage extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;       // Accessible from every method, using $this->data

    /**
     * Create a new message instance using New NewCaseMessage($data).
     *
     * @return void
     */
    public function __construct($data=null)
    {
        $this->data = $data;   // Assign data to the public variable $data
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Technical Support - New Case #'.$this->data->id.' - Waiting for Nipponia')->view('mail.newcase', ["case"=>$this->data]);
    }
}
