<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'nome', 'email', 'password', 'nivel_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function endereco()
    {
        return $this->hasOne('App\Endereco');
    }

    public function telefones()
    {
        return $this->hasMany('App\Telefone');
    }

    public function documentos()
    {
        return $this->hasMany('App\Documento');
    }

    public function nivel() {
        return $this->belongsTo('App\Nivel');
    }

    public function agendamentosMedico()
    {
        return $this->hasMany('App\Agendamento', 'medico_id');
    }

    public function agendamentosPaciente()
    {
        return $this->hasMany('App\Agendamento', 'paciente_id');
    }
    
    public function especializacoes(){
        return $this->belongsToMany('App\Especializacao', 'usuarios_has_especializacoes', 'usuario_id', 'especializacao_id')->withPivot('tempo_retorno');
    }

    public function horarios(){
        return $this->hasMany('App\Horario');
    }

    public function logs(){
        return $this->hasMany('App\Log');
    }

    public function listaEspera(){
        return $this->hasMany('App\ListaEspera');
    }

    public function getCRM() {
        if($this->nivel_id == 3) {
            $crm = $this->documentos()->where('tipo_documento_id', 4)->first();

            if($crm) {
                return $crm;
            }
        }
        return '';
    }

    //Envio de e-mail para resetar senha
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    //Mutators
    public function setPasswordAttribute($val) {
        $this->attributes['password'] = Hash::needsRehash($val) ? Hash::make($val) : $val;
    }

    

}
