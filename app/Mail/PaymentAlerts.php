<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentAlerts extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $client;
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        return $this->from('alertasdat@gmail.com')
        ->subject('Recordatorio de Pago')
                ->view('emails.payment')->with([
                        'clientName' => $this->client->deudor,
                        'clientDay' => $this->client->charge_at,
                        'deuda' => $this->client->adeudo,
                        'month'=>date('m'),
                        'year' =>date('y')
                    ]);
    }
}
