<?php

use Illuminate\Database\Seeder;

class NiveisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('niveis')->insert([
            [
                "id"    => "1",
                "nome"  => "Administrador",
            ],
            [
                "id"    => "2",
                "nome"  => "Paciente",
            ],
            [
                "id"    => "3",
                "nome"  => "Médico",
            ],
            [
                "id"    => "4",
                "nome"  => "Atendente",
            ],
        ]);
    }
}
