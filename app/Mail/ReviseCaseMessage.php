<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviseCaseMessage extends Mailable
{
    use Queueable, SerializesModels;

    protected $case;       // Accessible from every method, using $this->data

    /**
     * Create a new message instance using New NewCaseMessage($data).
     *
     * @return void
     */
    public function __construct($case=null)
    {
        $this->case = $case;   // Assign data to the public variable $data
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Technical Support - Case #'.$this->case->id.' - Status Update - '.$this->case->status->statusname)->view('mail.updatecase', ["case"=>$this->case]);
    }
}
