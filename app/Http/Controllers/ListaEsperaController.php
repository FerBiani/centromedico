<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{ListaEspera, DiaSemana, Especializacao, Log, Usuario, Agendamento};
use App\Http\Requests\{ListaEsperaRequest};
use DB;
use auth;
class ListaEsperaController extends Controller
{
    public function index(){
        
        $data = [
            'dados' => ListaEspera::paginate(10),
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

    public function store(ListaEsperaRequest $request){
        DB::beginTransaction();
        try{ 
            ListaEspera::create([
                'paciente_id' => $request['lista']['paciente_id'],
                'dia_semana_id' => $request['lista']['dia_semana_id'],
                'especializacao_id' => $request['lista']['especializacao_id'],
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

    public function list(Request $request){
        $dados = new ListaEspera;

        if($request['pesquisa']) {
            $user = Usuario::where('nome', 'like', '%'.$request['pesquisa'].'%')->first();
            $dados = $dados->where('paciente_id', 'like', '%'.$user->id.'%');   
        }

        if($dados){
            $dados = $dados->paginate(10);
            return view('listaespera.table', compact('dados'));
        }else{
            return back()->with('error', 'Nenhum resultado foi encontrado');
        }
    }

}
