<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaEspera extends Model
{
    protected $table = 'lista_espera';

    protected $fillable = [
        'paciente_id', 'especializacao_id','dia_semana_id'
    ];

    public $timestamps = false;

    public function pacientes(){
        return $this->belongsTo('App\Usuario');
    }

    public function especializacoes(){
        return $this->belongsTo('App\Especializacao');
    }

    public function diasemana(){
        return $this->belongsTo('App\DiaSemana');
    }
}
