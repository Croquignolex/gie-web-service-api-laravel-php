<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailServiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $from;
    public $text;
    public $html;
    public $attach;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param $from
     * @param $text
     * @param $html
     * @param $attach
     * @param $subject
     */
    public function __construct($from, $text, $html, $attach, $subject)
    {
        $this->from = $from;
        $this->text = $text;
        $this->html = $html;
        $this->attach = $attach;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Data
        $mail = $this;
        $from = $this->from;
        $attach = $this->attach;

        // Mail sender
        $mail = is_null($from) ? $mail : $mail->from($from);

        // Mail subject and views
        $mail = $mail
            ->subject($this->subject)
            ->view('mail.service.normal')
            ->text('mail.service.plain');

        // Mail attach
        $mail = is_null($attach) ? $mail : $mail->attach($attach);

        // Return
        return $mail;
    }
}
