<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Horario extends Model
{
    use Notifiable, SoftDeletes;
    protected $table = 'horarios';

    protected $fillable = [
        'inicio', 'fim', 'dias_semana_id','usuario_id', 'especializacao_id'
    ];

    public function usuario(){
        return $this->belongsTo('App\Usuario');
    }

    public function dia()
    {
        return $this->belongsTo('App\DiaSemana', 'dias_semana_id');
    }

    public function especializacoes()
    {
        return $this->belongsTo('App\Especializacao', 'especializacao_id'); 
    }

    function diasDoMes() {

        $dayId = $this->dias_semana_id;
        $year = date('Y');
        $month = date('m');
        $daysError = 3;

        switch ($dayId) {
            case 1:
                $day = 'Monday';
                break;
            case 2:
                $day = 'Tuesday';
                break;
            case 3:
                $day = 'Wednesday';
                break;
            case 4:
                $day = 'Thursday';
                break;
            case 5:
                $day = 'Friday';
                break;
            case 6:
                $day = 'Saturday';
                break;
            case 7:
                $day = 'Sunday';
                break;
            default:
                # code...
                break;
        }

        $dateString = 'next '.$day;
    
        if (!strtotime($dateString)) {
            throw new \Exception('"'.$dateString.'" is not a valid strtotime');
        }
    
        $startDay = new \DateTime($dateString);
    
        // if ($startDay->format('j') > $daysError) {
        //     $startDay->modify('- 7 days');
        // }
    
        $days = array();
    
        while ($startDay->format('Y-m') <= $year.'-'.str_pad($year, 2, 0, STR_PAD_LEFT)) {
            $days[] = clone($startDay);
            $startDay->modify('+ 7 days');
        }
    
        return $days;
    }

    //MUTATORS
    public function getInicioAttribute($val) {
        return substr($val, 0, 5);
    }

    public function getFimAttribute($val) {
        return substr($val, 0, 5);
    }

}
