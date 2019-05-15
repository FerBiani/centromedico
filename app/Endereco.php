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

    public function usuario()
    {
        return $this->belongsTo('App\Usuario');
    }

    public function cidade() {
        return $this->belongsTo('App\Cidade');
    }
}
