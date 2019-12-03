<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipo_documentos';

    protected $fillable = [
        'tipo', 'possui_complemento'
    ];

    public $timestamps = false;

    public function documentos()
    {
        return $this->hasMany('App\Documento', 'tipo_documentos_id');
    }
}
