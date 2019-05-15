<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

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

    public function especializacoes(){
        return $this->belongsToMany('App\Especializacao', 'usuarios_has_especializacoes', 'usuario_id', 'especializacao_id');
    }

    public function setPasswordAttribute($val) {
        $this->attributes['password'] = Hash::needsRehash($val) ? Hash::make($val) : $val;
    }

}
