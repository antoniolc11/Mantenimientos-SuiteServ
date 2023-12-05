<?php

namespace App\Mail;

use App\Models\Aspirante;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// Define la clase de correo electrónico, que extiende de Mailable

class SendCurriculum extends Mailable
{

     // Utiliza los traits Queueable y SerializesModels proporcionados por Laravel
    use Queueable, SerializesModels;

    public $aspirante;

    public function __construct(Aspirante $aspirante)
    {
        $this->aspirante = $aspirante;
    }

    // Método build que define la lógica para construir el correo electrónico
    public function build()
    {
        // Retorna la vista 'emails.enviarCurriculum' para construir el cuerpo del correo
        // También se establece el asunto del correo electrónico
        return $this->view('emails.enviarCurriculum')
                    ->subject('Adjunta tu Curriculum');
    }
}
