<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';

    protected $fillable = [
        'uf', 'nome'
    ];

    public function cidades()
    {
        return $this->hasMany('App\Cidade');
    }
}
