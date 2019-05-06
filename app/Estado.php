<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';

    protected $fillable = [
        'uf', 'nome','pais_id'
    ];

    public function cidades()
    {
        return $this->hasMany('App\Cidade');
    }

    public function paises()
    {
        return $this->belongsTo('App\Pais');
    }
}
