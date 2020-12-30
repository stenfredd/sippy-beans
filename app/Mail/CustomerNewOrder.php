<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerNewOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $order = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order=null)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->order;
        return $this->view('emails.customer-new-order', compact('order'));
    }
}
