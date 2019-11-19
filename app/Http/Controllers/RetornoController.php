<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Agendamento, Usuario, Horario};
class RetornoController extends Controller
{
    // public function create($id){
    //     $agendamento = Agendamento::findOrFail($id);
    //     $data = [
    //         'consulta' => $agendamento,
    //         'horarios' => Horario::all()->where('usuario_id',$agendamento->medico_id),
    //         'title'  => 'Retorno de Consulta',
    //         'url' => '',
    //         'button' => 'Enviar'
    //     ];        
    //     return view('retorno.create', compact('data'));
    // }

    public function store(){
        
    }
}
