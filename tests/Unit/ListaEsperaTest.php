<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListaEsperaTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testNewWaitingListRegistration(){
        $response = $this->visit('/lista/create')
         ->select('1', 'paciente_id')
         ->select('1', 'dia_semana_id')
         ->select('1', 'especializacao_id')
         ->press('Enviar');
         $this->assertTrue(true);
      }
}
