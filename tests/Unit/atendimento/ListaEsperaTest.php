<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ListaEspera;

class ListaEsperaTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testNewWaitingListRegistration(){
       \App\ListaEspera::create([
            'paciente_id' => '6',
            'dia_semana_id' => '1',
            'especializacao_id' => '3',
          ]);
        
          $this->assertDatabaseHas('lista_espera', ['dia_semana_id' => '1']);
   
      }
}
