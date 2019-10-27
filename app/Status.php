<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    
    protected $table = 'status';

    protected $fillable = [
        'nome',
    ];

    public function agendamentos(){
        return $this->belongsTo('App\Agendamento');
    }
}
