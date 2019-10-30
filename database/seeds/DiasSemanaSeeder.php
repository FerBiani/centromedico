<?php

use Illuminate\Database\Seeder;

class DiasSemanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dias_semana')->insert([
            [
                "id"    => "1",
                "dia"  => "Segunda-feira",
            ],
            [
                "id"    => "2",
                "dia"  => "Terça-feira",
            ],
            [
                "id"    => "3",
                "dia"  => "Quarta-feira",
            ],
            [
                "id"    => "4",
                "dia"  => "Quinta-feira",
            ],
            [
                "id"    => "5",
                "dia"  => "Sexta-feira",
            ],
            [
                "id"    => "6",
                "dia"  => "Sábado",
            ],
            [
                "id"    => "7",
                "dia"  => "Domingo",
            ]
        ]);
    }
}
