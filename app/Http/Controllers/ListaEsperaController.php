<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{ListaEspera, DiaSemana, Especializacao, Log};
use DB;
use auth;
class ListaEsperaController extends Controller
{
    public function index(){
        
        $data = [
            'dados' => ListaEspera::all(),
            'url'    => 'lista'
        ];

        return view('listaespera.index', compact('data'));
    }

    public function create(){
        $data = [
            'title' => 'Lista de Espera de Pacientes',
            'dias' => DiaSemana::all(),
            'especializacoes' => Especializacao::all(),
            'method' => '',
            'button' => 'Enviar',
            'url' => 'lista/store'
        ];

        return view('listaespera.form', compact('data'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{ 
            ListaEspera::create([
                'paciente_id' => $request['paciente_id'],
                'dia_semana_id' => $request['dia_semana_id'],
                'especializacao_id' => $request['especializacao_id'],
            ]);
            DB::commit();
            Log::create([
                'usuario_id' => Auth::user()->id,
                'acao'        => 'Inclusão',
                'descricao'   => 'Usuário '.Auth::user()->nome.' colocou um paciente na lista de espera'
            ]);
            return redirect('lista')->with('success', 'Horário registrado com sucesso!');
         }catch(\Exception $e){
            DB::rollback();
            return back()->with('error', 'Erro no servidor');
        }
    }
}
