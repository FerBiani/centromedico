<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgendamentoTest extends TestCase
{
    
    public function testNewScheduleRegistration(){
        \App\Agendamento::create([
              'inicio' => '2019-11-21 08:00:00',
              'fim' => '2019-11-21 09:00:00',
              'paciente_id' => '2',
              'medico_id' => '5',
              'especializacao_id' => '1',
              'codigo_check_in' => '425',
              'check_in_id' => '1',
              'status_id' => '1',
              'agendamento' => ''
         ]);
         $this->assertDatabaseHas('agendamentos', ['codigo_check_in' => '425']);
    }
}
