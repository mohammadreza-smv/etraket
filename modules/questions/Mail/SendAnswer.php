<?php

namespace Modules\questions\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAnswer extends Mailable
{
    use Queueable, SerializesModels;

    public $answer;
    public $question;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($question,$answer)
    {
        $this->question=$question;
        $this->answer=$answer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('questions::mail.send_answer')
            ->subject('دریافت پاسخ - دیجی آنلاین');
    }
}
