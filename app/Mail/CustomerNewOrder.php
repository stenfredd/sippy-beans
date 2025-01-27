<?php

namespace App\Mail;

use App\Models\Grind;
use Illuminate\Bus\Queueable;
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
    public function __construct($order = null)
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
        foreach ($order->details as $detail) {
            $detail->grind_title = Grind::find($detail->grind_id)->title ?? null;
        }
        return $this->view('emails.customer-new-order', compact('order'));
    }
}
