<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendbulkEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sendTo;
    public $name;
    public $CourseName;
    public $Specialization;
    public $company_name;
    public $link;
   
    /**
     * Create a new job instance.
     */
    public function __construct($sendTo, $name,$CourseName,$Specialization,$company_name,$link)
    {
        $this->sendTo = $sendTo;
        $this->name = $name;
        $this->CourseName = $CourseName;
        $this->Specialization = $Specialization;
        $this->company_name= $company_name;
        $this->link = $link;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        
        mail_send(25, ['#Name#','#CourseName#','#Specialization#','#company_name#','#Link#',], [$this->name,$this->CourseName, $this->Specialization,  $this->company_name,$this->link], $this->sendTo);
    }
}
