<?php

use Illuminate\Database\Seeder;

class StatusAgendamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_agendamento')->insert([
            [
                "id"    => "1",
                "nome"  => "Confirmada",
            ],
            [
                "id"    => "2",
                "nome"  => "Cancelada",
            ],
            [
                "id"    => "3",
                "nome"  => "Paciente não compareceu",
            ],
            [
                "id"    => "4",
                "nome"  => "Finalizada",
            ],
        ]);
    }
}
