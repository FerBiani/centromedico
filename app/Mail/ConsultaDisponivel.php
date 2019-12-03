<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ListaEspera;

class ConsultaDisponivel extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $listaEspera;

    public function __construct($listEspera)
    {
        $this->listEspera = ListaEspera::find($listEspera->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.agendamentos.disponivel')
            ->with([
                'nomePaciente'  => \App\Usuario::find($this->listEspera->paciente_id)->nome,
                'especialidade' => \App\Especializacao::find($this->listEspera->especializacao_id)->especializacao,
            ]);
    }
}
