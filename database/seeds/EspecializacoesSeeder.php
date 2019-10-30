<?php

use Illuminate\Database\Seeder;

class EspecializacoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('especializacoes')->insert([
            [
                "id"    => "1",
                "especializacao" => "Cardiologia"
            ],
            [
                "id"    => "2",
                "especializacao" => "Neurologia"
            ],
            [
                "id"    => "3",
                "especializacao" => "Nutrição"
            ],
            [
                "id"    => "4",
                "especializacao" => "Psiquiatria"
            ]
        ]);
    }
}
