<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HorarioTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNewUserRegistration(){
       $response = $this->visit('/medicos/horario/create')
        ->select('1', 'horario[tipo]')
        ->select('1', 'horario[especializacao_id]')
        ->select('1', 'horario[dia_semana]')
        ->type('08:00', 'horario[inicio]')
        ->type('09:00', 'horario[fim]')
        ->press('Enviar');
        $this->assertTrue(true);
     }
}
