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
    public function testNewTimeRegistration(){
    \App\Horario::create([
       'inicio' => '08:00',
         'fim' => '09:00',
         'dias_semana_id' => '2',
         'usuario_id' => '3',
         'especializacao_id' => '1',
    ]);
    $this->assertDatabaseHas('horarios', ['inicio' => '08:00']);

   }
}

