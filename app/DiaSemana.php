<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaSemana extends Model
{
    protected $table = 'dias_semana';

    protected $fillable = [
        'dia'
    ];

    public $timestamps = false;

    public function horarios()
    {
        return $this->belongsTo('App\Horario');
    }

    public function listaEspera()
    {
        return $this->hasMany('App\Lista');
    }
}
