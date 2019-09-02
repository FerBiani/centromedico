<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';

    protected $fillable = [
        'inicio', 'fim', 'paciente_id','medico_id', 'especializacoes_id'
    ];

    public $timestamps = false;

    public function usuarios(){
        return $this->hasMany('App\Usuario');
    }

    public function especializacoes(){
        return $this->belongsTo('App\Especializacao');
    }
}
