<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerOrderCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $order = null;
    public $detail_ids = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order = null, $detail_ids = null)
    {
        $this->order = $order;
        $this->detail_ids = $detail_ids;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->order;
        $detail_ids = $this->detail_ids;
        return $this->view('emails.customer-order-cancelled', compact('order', 'detail_ids'));
    }
}
