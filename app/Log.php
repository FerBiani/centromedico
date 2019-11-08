<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'usuario_id','acao','descricao'
    ];

    public function usuarios()
    {
        return $this->belongsTo('App\Usuario');
    }

    public function getCor(){
        $acao = $this->acao;
        
        switch ($acao) {
            case 'Inclusão':
                $cor = 'success';
                break;
            case 'Exclusão':
                $cor = 'danger';
                break;
            case 'Alteração':
                $cor = 'warning';
                break;
            case 'Check-in':
                $cor = 'info';
                break;
            default:
                $cor = 'warning';
                break;
        }
        return $cor;
    }
}
