<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\AdminAnnouncementMail;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $recieverName;
    protected $email;
    protected $notificationTitle;
    protected $notificationDescription;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $recieverName, $notificationTitle, $notificationDescription)
    {
        $this->email = $email;
        $this->recieverName = $recieverName;
        $this->notificationTitle = $notificationTitle;
        $this->notificationDescription = $notificationDescription;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)
            ->cc($this->email)
            ->send(new AdminAnnouncementMail($this->recieverName, $this->notificationTitle, $this->notificationDescription));
    }
}
