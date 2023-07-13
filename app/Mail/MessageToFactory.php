<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageToFactory extends Mailable
{
    use Queueable, SerializesModels;

    protected $incoming;
    protected function cases_folder($case_id) 
    { 
        return Storage::disk('public')->path('cases/'.$case_id.'/');     // relative to storage/app/public
    } 

    /**
     * Create a new message instance using New new MessageToFactory($data).
     *
     * @return void
     */
    public function __construct(Request $incoming)
    {
        $this->incoming = $incoming;   // Assign data to the protected $data
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to($this->incoming->to)
            ->cc($this->incoming->cc)
            ->subject($this->incoming->emailsubject)
            ->view('mail.factory', ['body'=> $this->incoming->emailbody]);
        if ($this->incoming->attachments){
            foreach ($this->incoming->attachments as $attachment) {
                $this->attach($this->cases_folder($this->incoming->case_id).$attachment);
            }
        }
        
        
        return $this;
    }
}
