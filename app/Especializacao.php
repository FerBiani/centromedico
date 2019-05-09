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
        return $this->belongsToMany('App\Usuarios', 'usuarios_has_especializacoes', 'usuarios_id', 'especializacoes_id');
    }
}
