<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{StatusAgendamento, Agendamento, Usuario, Especializacao};

class RelatorioController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Relatórios',
            'agendamentos' => [
                'confirmados' => Agendamento::where("status_id", 1)->count(),
                'cancelados' => Agendamento::where("status_id", 2)->count(),
                'naoCompareceu' => Agendamento::where("status_id", 3)->count(),
                'finalizados' => Agendamento::where("status_id", 4)->count(),
            ]
        ];
        return view('relatorio.index', compact('data'));
    }

    public function pacientes(){
       $medicos = Usuario::where('nivel_id', 3)->paginate(10);
       return view('impressos.pacientes', compact('medicos')); 
    }

    public function consultas($id){
       $consultas = Agendamento::where('medico_id', $id)->whereDate('inicio', date('Y-m-d'))->get();
       return view('impressos.programacaodiaria', compact('consultas'));
    }

     public function list(Request $request){
        $dados = new Usuario;

        if($request['pesquisa']) {
            $dados = Usuario::where('nome', 'like', '%'.$request['pesquisa'].'%')->where('nivel_id',3);   
        }else{
            $dados = Usuario::where('nivel_id',3);
        }

        if($dados){
            $dados = $dados->paginate(10);
            return view('impressos.resultados', compact('dados'));
        }else{
            return back()->with('error', 'Nenhum resultado foi encontrado');
        }

    }

    public function atestado($id){
        $consulta = Agendamento::findOrFail($id);
        return view('impressos.horarios', compact('consulta'));
    }
}
