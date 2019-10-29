<?php

use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            [
                "id"        => "1",
                "nome"      => "Administrador",
                'email'     => 'admin@admin.com',
                'password'  => '$2y$10$t0pMVs3cxXyzoQYpI36c8.XEkU6H6VzaNlCmpj7LyEnlbPMZvVoRC',
                'nivel_id'  => '1'
            ],
            [
                "id"        => "2",
                "nome"      => "Paciente",
                'email'     => 'paciente@paciente.com',
                'password'  => '$2y$10$t0pMVs3cxXyzoQYpI36c8.XEkU6H6VzaNlCmpj7LyEnlbPMZvVoRC',
                'nivel_id'  => '2'
            ],
            [
                "id"        => "3",
                "nome"      => "Médico",
                'email'     => 'medico@medico.com',
                'password'  => '$2y$10$t0pMVs3cxXyzoQYpI36c8.XEkU6H6VzaNlCmpj7LyEnlbPMZvVoRC',
                'nivel_id'  => '3'
            ],
            [
                "id"        => "4",
                "nome"      => "Atendente",
                'email'     => 'atendente@atendente.com',
                'password'  => '$2y$10$t0pMVs3cxXyzoQYpI36c8.XEkU6H6VzaNlCmpj7LyEnlbPMZvVoRC',
                'nivel_id'  => '4'
            ],
        ]);
    }
}
