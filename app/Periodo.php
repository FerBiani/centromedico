<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodos';

    protected $fillable = [
        'inicio', 'fim', 'dia_semana','usuarios_id'
    ];

    public $timestamps = false;

    public function usuarios(){
        return $this->hasOne('App\Usuario');
    }

}
