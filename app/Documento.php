<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{

    protected $table = 'documentos';

    protected $fillable = [
        'tipo_documentos_id', 'numero','usuario_id'
    ];

    public $timestamps = false;

    public function usuarios()
    {
        return $this->belongsTo('App\Usuario');
    }

    public function tipodocumentos()
    {
        return $this->hasOne('App\TipoDocumento');
    }

}
