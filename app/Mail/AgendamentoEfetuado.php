<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Agendamento;

class AgendamentoEfetuado extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $agendamento;

    public function __construct(Agendamento $agendamento)
    {
        $this->agendamento = $agendamento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.agendamentos.efetuado')
            ->with([
                'nomePaciente'  => $this->agendamento->paciente->nome,
                'nomeMedico'    => $this->agendamento->medico->nome,
                'especialidade' => $this->agendamento->especializacao->especializacao,
                'inicio'        => $this->agendamento->inicio,
                'fim'           => $this->agendamento->fim,
                'codigoCheckIn' => $this->agendamento->codigo_check_in
            ]);
    }
}
