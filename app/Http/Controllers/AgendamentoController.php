<?php

namespace App\Http\Controllers;

use App\{Usuario, Nivel, Agendamento, Especializacao, Horario, DiaSemana, StatusAgendamento, Log};
use Illuminate\Http\Request;
use App\Http\Resources\UsuarioCollection;
use App\Http\Requests\{AgendamentoCreateRequest};
use App\Mail\AgendamentoEfetuado;
use DB;
use Illuminate\Support\Facades\Mail;
use Auth;

class AgendamentoController extends Controller
{
    public function index(){
        if(Auth::user()->nivel_id == 2) {   
            $data = [
                'title' => 'Meus Agendamentos',
                'consultas' => Agendamento::where('paciente_id',Auth::user()->id)->orderBy('inicio', 'ASC')->paginate(10)
            ];
            return view('usuario.pacientes.agendamentos', compact('data'));
        }
        else if(Auth::user()->nivel_id == 3) {
            $data = [
                'title' => 'Meus agendamentos',
                'consultas' => Agendamento::where('medico_id',auth::user()->id)->orderBy('inicio', 'ASC')->paginate(10),
                'status' => StatusAgendamento::all()
            ];

            return view('usuario.medicos.agendamentos', compact('data'));
        } else {
            $data = [
                'title' => 'Agendamentos',
                'consultas' => Agendamento::orderBy('inicio', 'ASC')->paginate(10),
                'status' => StatusAgendamento::all()
            ];
            return view('agendamento.index', compact('data'));
        }
    }

    public function create()
    {
        $data = [
            'method' => '',
            'button' => 'Buscar',
            'url'    => 'pacientes/agendamento',
            'title'  => 'Agendamento de Consultas',
            'dias'   => DiaSemana::all(),
            'especializacoes' => Especializacao::all(),
        ];
        return view('usuario.atendente.agendamento', compact('data'));
    }

    public function confirma($id){
        $data = [
            'method'  => '',
            'button'  => 'Confirmar',
            'url'     => 'atendente/agendamento/',
            'title'   => 'Confirmação de agendamento de consulta',
            'horario' => Horario::find($id),
        ];
        return view('usuario.atendente.confirmacao', compact('data'));
    }

    public function pacientes(){
        $pacientes = Usuario::where('nivel_id',2)->paginate(10);
        return $pacientes;
    }

    public function store(Request $request)
    {   

        $inicio = $request['data'].' '.$request['inicio'];
        $fim = $request['data'].' '.$request['fim'];

        $horariosIndisponiveis = [];

        $agendamentosMedico = Usuario::findOrFail($request['medico_id'])->agendamentosMedico;

        foreach($agendamentosMedico as $agendamento) {
            $horariosIndisponiveis[] = $agendamento->inicio;
        }

        if(in_array($inicio.':00', $horariosIndisponiveis)) {
            return redirect('/')->with('error', 'Não é possível marcar uma consulta nesta data!');
        }

         DB::beginTransaction();
        try{
            $agendamento = Agendamento::create([
                'inicio' => $inicio,
                'fim' => $fim,
                'status_id' => 1,
                'paciente_id' => (int)$request['paciente_id'],
                'medico_id'  => (int)$request['medico_id'],
                'especializacao_id' => (int)$request['especializacao_id'],
                'codigo_check_in' => $request['paciente_id'].$request['especializacao_id'].$request['medico_id'],
            ]);

            //Log
            Log::create([
                'usuario_id' => Auth::user()->id,
                'acao'        => 'Inclusão',
                'descricao'   => 'Usuário '.Auth::user()->nome.' cadastrou um agendadamento'
            ]);


            Mail::to($agendamento->paciente->email)->send(new AgendamentoEfetuado($agendamento));

              DB::commit();

              return redirect('agendamentos')->with('success', 'Consulta marcada com sucesso');

        }catch(\Exception $e){
            DB::rollback();
            return back()->with('error', $e);
        }
    }

    public function filtro(Request $request) {

        $horarios = new Horario;

        if($request['especializacoes_id']){
            $especializacao = Especializacao::findOrFail($request['especializacoes_id']);

            $horarios = $horarios->where('especializacao_id', $especializacao->id);
        }

        if($request['dias_semana_id']){
            $horarios = $horarios->where('dias_semana_id', $request['dias_semana_id']);
        }

        $horarios = $horarios->paginate(10);
        return view('usuario.atendente.resultados', compact('horarios'));
    }

    public function show($id){}

    public function edit($id){}

    public function update(Request $request, $id)
    {
        $agendamento = Agendamento::whereId($id)->update($request->except(['_method', '_token']));
        Log::create([
            'usuario_id' => Auth::user()->id,
            'acao'        => 'Alteração',
            'descricao'   => 'Usuário '.Auth::user()->nome.' alterou um agendadamento'
        ]);
        return back();
    }

    public function setStatus(Request $request, $id){
        $agendamento = Agendamento::findOrFail($id);

        $date = strtotime($agendamento->getOriginal('inicio')."-1 day");
    
        if($date > date("Y-m-d H:i:s") && $request->input('status_id') === 2) {
            return response()->json(['message' => 'Você não pode cancelar esta consulta!'], 403);
        }

        DB::beginTransaction();
        try {

            $agendamento->update(['status_id' => $request->input('status_id')]);

            Log::create([
                'usuario_id' => Auth::user()->id,
                'acao'        => 'Atualização',
                'descricao'   => 'Usuário '.Auth::user()->nome.' alterou o status da consulta'
            ]);  
            DB::commit();
            return response()->json(['message' => 'Status da consulta alterado com sucesso!'], 200);
        } catch(\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function destroy($id)
    {
        $agendamento = Agendamento::find($id);
        if(date($agendamento->inicio, strtotime('-24 hours', time()))){
            $agendamento->delete();
            Log::create([
                'usuario_id' => Auth::user()->id,
                'acao'        => 'Exclusão',
                'descricao'   => 'Usuário '.Auth::user()->nome.' deletou um agendadamento'
            ]);    
            return back()->with('success', 'Consulta cancelada com sucesso');
        }else{
            return back()->with('success', 'Falha ao cancelar a consulta');
        }
        
    }

    public function getDisponibilidade($medico){
        $disponibilidades = Periodo::where('usuarios_id',$medico)->first();
        echo $disponibilidades;
    }

    public function getDias($medico){
        $dias = Periodo::where('usuarios_id', $medico)->get();
        echo $dias;
    }

}
