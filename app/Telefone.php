<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{

    protected $table = 'telefones';

    protected $fillable = [
        'numero','usuario_id'
    ];

    public $timestamps = false;

    public function usuarios()
    {
        return $this->belongsTo('App\Usuario');
    }

    // public function setNumeroAttribute($val){
        
    // }

    // public function getNumeroAttribute($val){
       
    // }


}