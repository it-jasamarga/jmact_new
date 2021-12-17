<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Email;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $view;
    public $subject;
    public $email;
    public $record;
    public $users;
    
    /**
     * Create a new messages instance.
     *
     * @return void
     */
    public function __construct($view, $subject, $email, $record, $users)
    {
        $this->view = $view;
        $this->subject = $subject;
        $this->email = $email;
        $this->record = $record;
        $this->user = $users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Email::create([
            'subject' => @$this->subject,
            'email' => @$this->email,
            'status' => 'Message Out'
        ]);

        $mail = $this->subject($this->subject)->view($this->view);

        if (@$this->record->files && count($this->record->files) > 0) {
            foreach ($this->record->files as $attachment) {
                if (file_exists(storage_path() . '/app/public/' . $attachment->url)) {
                    $mail->attach(storage_path('app/public/' . $attachment->url));
                }
            }
        }
        return $mail;
    }
}
