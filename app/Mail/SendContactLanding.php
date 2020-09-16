<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContactLanding extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $client;
    public function __construct($name,$correo,$ciudad,$empresa,$unidades,$comentarios)
    {

        $this->name = $name;
        $this->correo = $correo;
        $this->ciudad = $ciudad;
        $this->empresa = $empresa;
        $this->unidades = $unidades;
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
                ->view('emails.sendContactLanding')->with([
                        'name' => $this->name,
                        'correo' => $this->correo,
                        'ciudad' => $this->ciudad,
                        'empresa'=>$this->empresa,
                        'unidades'=>$this->unidades,
                        'comentarios'=>$this->comentarios

                    ]);
    }
}
