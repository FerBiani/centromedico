<?php

use Illuminate\Database\Seeder;

class TipoDocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_documentos')->insert([
            [
                'id' => '1',
                'tipo' => 'RG'
            ],
            [
                'id' => '2',
                'tipo' => 'CPF'
            ],
            [
                'id' => '3',
                'tipo' => 'CNH'
            ],
            [
                'id' => '4',
                'tipo' => 'Título de Eleitor'
            ]
        ]);
    }
}
