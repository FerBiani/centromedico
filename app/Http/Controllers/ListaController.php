<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Especializacao, Usuario, Agendamento};
use auth;

class ListaController extends Controller
{
    public function index(){
       if(Auth::user()->nivel_id == 3){
        $consultas = Agendamento::whereDate('inicio', date('Y-m-d'))->where('medico_id', Auth::user()->id)->paginate(10);
       }else{
        $consultas = Agendamento::whereDate('inicio', date('Y-m-d'))->paginate(10);
       }
        return view('lista.index', compact('consultas'));
    }

    public function list(Request $request){
        $dados = Usuario::where('nome', 'like', '%'.$request['pesquisa'].'%')->where('nivel_id',3)->first();   
        $consultas = Agendamento::whereDate('inicio', date('Y-m-d'))->where('medico_id', $dados->id)->paginate(10);
        return view('lista.table', compact('consultas'));
    }
}
