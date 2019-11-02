<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'usuario_id','acao','descricao'
    ];

    public function usuarios()
    {
        return $this->belongsTo('App\Usuario');
    }
}
