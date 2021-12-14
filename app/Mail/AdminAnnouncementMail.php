<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class AdminAnnouncementMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $full_name;
    protected $title;
    protected $description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($full_name, $title, $description)
    {
        $this->full_name = $full_name;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.AdminAnnouncementMailTemplate')
            ->subject('SOIS-AR Announcement: ' . $this->title)
            ->with([
                'full_name' => $this->full_name,
                'title' => $this->title,
                'description' => $this->description,
            ]);
    }
}
