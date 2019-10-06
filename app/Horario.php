<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'inicio', 'fim', 'dias_semana_id','usuario_id', 'especializacao_id'
    ];

    public function usuario(){
        return $this->hasOne('App\Usuario');
    }

    public function dias()
    {
        return $this->hasOne('App\DiaSemana');
    }

    public function especializacoes()
    {
        return $this->hasOne('App\Especializacao'); 
    }

}
