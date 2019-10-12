<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Horario extends Model
{
    use Notifiable, SoftDeletes;
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

    //MUTATORS
    public function getInicioAttribute($val) {
        return substr($val, 0, 5);
    }

    public function getFimAttribute($val) {
        return substr($val, 0, 5);
    }

}
