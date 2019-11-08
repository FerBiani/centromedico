<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especializacao extends Model
{
    protected $table = 'especializacoes';

    protected $fillable = [
        'especializacao'
    ];

    public $timestamps = false;

    public function usuarios(){
    	return $this->belongsToMany('App\Usuario', 'usuarios_has_especializacoes', 'especializacao_id', 'usuario_id');
    }

    public function consultas(){
        return $this->hasMany('App\Consulta');
    }

    public function horarios(){
        return $this->belongsTo('App\Horario');
    }

    public function listaEspera()
    {
        return $this->hasMany('App\Lista');
    }
}
