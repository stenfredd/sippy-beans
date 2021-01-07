<?php

namespace App\Mail;

use App\Models\Grind;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MerchantNewOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $order = null;
    public $details = null;
    public $seller = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order = null, $details = null, $seller = null)
    {
        $this->order = $order;
        $this->details = $details;
        $this->seller = $seller;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->order;
        $seller = $this->seller;
        $details = $this->details;
        foreach ($order->details as $detail) {
            $detail->grind_title = Grind::find($detail->grind_id)->title ?? null;
        }
        return $this->view('emails.merchant-new-order', compact('order', 'details', 'seller'));
    }
}
