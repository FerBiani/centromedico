<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'inicio', 'fim', 'dia_semana','usuario_id'
    ];

    public function usuario(){
        return $this->hasOne('App\Usuario');
    }

}
