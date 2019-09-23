<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $table = 'agendamentos';

    protected $fillable = [
        'data', 'hora', 'paciente_id','medico_id', 'especializacoes_id'
    ];

    public $timestamps = false;

    public function usuarios(){
        return $this->hasMany('App\Usuario');
    }

    public function especializacoes(){
        return $this->belongsTo('App\Especializacao');
    }
}
