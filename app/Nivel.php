<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{

    protected $table = 'niveis';

    protected $fillable = [
        'nome',
    ];
}
