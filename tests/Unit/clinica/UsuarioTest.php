<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioTest extends TestCase
{
    public function testNewUserRegistration()
    {
        \App\Usuario::create([
            "nome" => "Paciente",
            "email" => "paciente@email.com",
            "password" => "123456",
            "password_confirmation" => "123456",
            "nivel_id" => "2"
       ]);
       $this->assertDatabaseHas('usuarios', ['email' => 'paciente@email.com']);
    }
}
