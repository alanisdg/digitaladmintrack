<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $client;
    public function __construct($nombre,$telefono,$compania,$comentarios)
    {

        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->compania = $compania;
        $this->comentarios = $comentarios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        return $this->from('alertasdat@gmail.com')
        ->subject('Contacto desde DAT')
                ->view('emails.sendContact')->with([
                        'nombre' => $this->nombre,
                        'telefono' => $this->telefono,
                        'compania'=>$this->compania,
                        'comentarios'=>$this->comentarios
                    ]);
    }
}
