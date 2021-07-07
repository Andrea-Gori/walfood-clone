<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order;
    public $summary;
    public $datiUtente;
    public function __construct($order, $summary, $datiUtente)
    {
        $this->order = $order;
        $this->summary = $summary;
        $this->datiUtente = $datiUtente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Il tuo ordine su Walfood')->markdown('emails.orders.shipped');
    }
}
