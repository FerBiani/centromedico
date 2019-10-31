<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EstadosSeeder::class);
        $this->call(TipoDocumentosSeeder::class);
        $this->call(DiasSemanaSeeder::class);
        $this->call(EspecializacoesSeeder::class);
        $this->call(NiveisSeeder::class);
        $this->call(StatusAgendamentoSeeder::class);
        $this->call(UsuariosSeeder::class);
    }
}
