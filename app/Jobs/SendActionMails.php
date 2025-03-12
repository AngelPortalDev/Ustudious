<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendActionMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $subject;
    protected $content;
    protected $recipient;
    protected $sendcc;
    protected $replayto;
    /**
     * Create a new job instance.
     */
    public function __construct($subject, $content, $recipient,$sendcc=[],$replayto=[])
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->recipient = $recipient ?? 'test@gmail.com';
        $this->sendcc = $sendcc;
        $this->replayto = $replayto;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::send('mails.mailBody', ['newContain' => $this->content], function ($message) {
                $message->from(env('MAIL_FROM_ADDRESS'));
                $message->to($this->recipient);
                $message->subject($this->subject);
                if ($this->sendcc) {
                    $message->cc($this->sendcc);
                }
                if ($this->replayto) {
                    $message->replyTo($this->replayto);
                }
                
            });        

        } catch (\Exception $e) {
            
            Log::error('Email sending failed', [
                'error' => $e->getMessage(),
                'recipient' => $this->recipient
            ]);
        }
    
    }
}
