<?php

namespace App\Jobs;

use App\Mail\NewCaseMessage;
use Illuminate\Bus\Queueable;
use App\Mail\ReviseCaseMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendCaseEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $incoming;       
    protected $case;    // Accessible from every method, using $this->case
    protected $recepient = 'Ismini.Zounta@nipponia.com';
    protected $action;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($incoming)
    {
        $this->case = $incoming;   // Assign data to the protected variable $case
        $this->case = $incoming['case'];
        $this->action = $incoming['action'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->action == 'new'){
            Mail::to($this->recepient)->send(new NewCaseMessage($this->case));
        } elseif ($this->action == 'revise'){
            Mail::to($this->recepient)->send(new ReviseCaseMessage($this->case));
        }
    }
}
