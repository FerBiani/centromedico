<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $table = 'agendamentos';

    protected $fillable = [
        'inicio', 'fim', 'paciente_id', 'medico_id', 'especializacao_id', 'codigo_check_in', 'check_in_id'
    ];

    public function paciente()
    {
        return $this->belongsTo('App\Usuario', 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo('App\Usuario', 'medico_id');
    }

    public function checkIn() {
        return $this->belongsTo('App\CheckIn');
    }

    public function especializacao()
    {
        return $this->belongsTo('App\Especializacao');
    }

}
