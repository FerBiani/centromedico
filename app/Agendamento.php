<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $table = 'agendamentos';

    protected $fillable = [
        'inicio', 'fim', 'paciente_id', 'medico_id', 'especializacao_id','codigo_check_in', 'check_in_id', 'status_id', 'agendamento_id'
    ];

    public function paciente()
    {
        return $this->belongsTo('App\Usuario', 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo('App\Usuario', 'medico_id');
    }

    public function checkIn() {
        return $this->belongsTo('App\CheckIn');
    }

    public function especializacao()
    {
        return $this->belongsTo('App\Especializacao');
    }

    public function status() {
        return $this->belongsTo('App\StatusAgendamento');
    }

    public function setFimAttribute($val) {
        $horario = explode(' ', $val)[1];
        $this->attributes['fim'] = implode('-', array_reverse(explode('/', explode(' ', $val)[0]))).' '.$horario;
    }

    public function getFimAttribute($val) {
        $horario = explode(' ', $val)[1];
        return $this->attributes['fim'] = implode('/', array_reverse(explode('-', explode(' ', $val)[0]))).' '.$horario;
    }

    public function setInicioAttribute($val) {
        $horario = explode(' ', $val)[1];
        $this->attributes['inicio'] = implode('-', array_reverse(explode('/', explode(' ', $val)[0]))).' '.$horario;
    }

    public function getInicioAttribute($val) {
        $horario = explode(' ', $val)[1];
        return $this->attributes['inicio'] = implode('/', array_reverse(explode('-', explode(' ', $val)[0]))).' '.$horario;
    }

}
