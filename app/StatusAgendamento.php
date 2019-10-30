<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusAgendamento extends Model
{
    
    protected $table = 'status_agendamento';

    protected $fillable = [
        'nome',
    ];

    public function agendamentos(){
        return $this->belongsTo('App\Agendamento');
    }
}
