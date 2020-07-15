<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
//use Illuminate\Contracts\Queue\ShouldQueue;

class EmailServiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $text;
    public $html;
    public $source;
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
        $this->text = $text;
        $this->html = $html;
        $this->source = $from;
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
        $source = $this->source;
        $attach = $this->attach;

        // Mail sender
        if(!is_null($source)) $this->from($source);

        // Mail subject and views
        $this->subject($this->subject)
            ->view('mail.service.normal')
            ->text('mail.service.plain');

        // Mail attach
        if(!is_null($attach)) $this->attach($attach);

        // Return
        return $this;
    }
}
