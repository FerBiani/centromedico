<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{

    protected $table = 'enderecos';

    protected $fillable = [
        'cep', 'logradouro', 'bairro', 'numero','complemento','usuario_id','cidade_id'
    ];

    public $timestamps = false;

    public function usuarios()
    {
        return $this->hasOne('App\Usuario');
    }
}
