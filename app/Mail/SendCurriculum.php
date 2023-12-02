<?php

namespace App\Mail;

use App\Models\Aspirante;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCurriculum extends Mailable
{
    use Queueable, SerializesModels;

    public $aspirante;

    public function __construct(Aspirante $aspirante)
    {
        $this->aspirante = $aspirante;
    }

    public function build()
    {
        return $this->view('emails.enviarCurriculum')
                    ->subject('Adjunta tu Curriculum');
    }
}
