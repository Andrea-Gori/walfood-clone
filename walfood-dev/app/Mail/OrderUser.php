<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order;
    public $summary;
    public $datiUser;
    public function __construct($order, $summary, $datiUser)
    {
        $this->order = $order;
        $this->summary = $summary;
        $this->datiUser = $datiUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ordine ricevuto su "' . $this->order->restaurant->business_name . '"!')->markdown('emails.orders.user');
    }
}
