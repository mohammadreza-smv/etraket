<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $product_title;

    public $product_status;

    public $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$status,$reject_message)
    {
       $this->product_title=$title;
       $this->product_status=$status;
       $this->message=$reject_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.product-status')
            ->subject('تغییر وضعیت محصول شما');
    }
}
