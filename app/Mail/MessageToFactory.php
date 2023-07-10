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
        return Storage::disk('public')->path('public/cases/'.$case_id.'/');     
        // ναι, θέλει πάλι public, διότι το Storage::disk('public') είναι το storage/app
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
