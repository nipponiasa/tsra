<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailOut extends Mailable
{
    use Queueable, SerializesModels;

 public $data; //aytos tha einai o pinakas poy gemizv me keys kai meta emfanizetai sto mail, ton pairno kata th dimiourgia ths klashs new MailOut
 public $type;  //typos gia na xerei ti tha xrisimopoihsei
 
 
 /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datafromcontroller,$type)
    {
$this->data=$datafromcontroller;
$this->type=$type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->type) 
            {
                case "send_ext_tr_new":
                    $subject=$this->data['subject'];
                    // $subject = $this->data->subject;
                    return $this
                   //->attachFromStorage("51/0/N6zKzmSRvXvNxUGJ0tc2CuFwi6RM3mgk5JNQDeTW.png")
                    ->subject($subject)
                    ->view('mail.out.troutnew');




                  break;
                case "send_ext_tr_new_vendor":
                 
                    $subjectcase=$this->data['subjectcase'];
                    $attachments=$this->data['attachments'];
                   // dd($subject);
                   if(!is_null($this->data['attachments'])) {
                   foreach ($attachments as $attachment) {
                    $this->attachFromStorage( $attachment);
                }

            }

                    return $this
                    ->subject($subjectcase)
                    ->view('mail.out.troutnewvendor');
                 break;
               
                default:
                $subject=$this->data['subject'];
                // $subject = $this->data->subject;
                return $this
               //->attachFromStorage("92/69/fIrvH3G21WyRY4XSDIJyPfCMYkwORYAOgsMJz0ok.jpg")
                ->subject($subject)
                ->view('mail.out.troutnew');
              } 







        
    }
}
