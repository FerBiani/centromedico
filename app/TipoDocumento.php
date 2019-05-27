<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipo_documentos';

    protected $fillable = [
        'tipo'
    ];

    public $timestamps = false;

    public function documentos()
    {
        return $this->belongsTo('App\Documento');
    }
}
