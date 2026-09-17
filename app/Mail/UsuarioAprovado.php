<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsuarioAprovado extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;

    /**
     * Create a new message instance.
     */
    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Seu cadastro foi aprovado — SESI')
                    ->view('emails.usuario_aprovado')
                    ->with(['usuario' => $this->usuario]);
    }
}
