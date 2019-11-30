<?php

namespace App\Http\Controllers;

use App\{Usuario, Nivel, Agendamento, Especializacao, Horario, DiaSemana, StatusAgendamento, Log, ListaEspera};
use Illuminate\Http\Request;
use App\Http\Resources\UsuarioCollection;
use App\Http\Requests\{AgendamentoRequest};
use App\Mail\AgendamentoEfetuado;
use App\Mail\ConsultaDisponivel;
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
            'horarios' => Horario::paginate(10)
        ];
        return view('usuario.atendente.agendamento', compact('data'));
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

        if($request['horario']){
            $horarios = $horarios->where('inicio','>=', $request['horario']);
        }
        if($request['fim']){
            $horarios = $horarios->where('inicio', '<=', $request['fim']);
        }

        $horarios = $horarios->paginate(10);
        return view('usuario.atendente.resultados', compact('horarios'));
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

    public function pacientes(Request $request){
        $pacientes = Usuario::where('nivel_id',2)->where('nome', 'like', $request->q.'%');

        return json_encode($pacientes->paginate(10, ['*'], 'page', $request->page));
    }

    public function store(AgendamentoRequest $request)
    {
        
        $inicio = $request['agendamento']['data'].' '.$request['agendamento']['inicio'];
        $fim = $request['agendamento']['data'].' '.$request['agendamento']['fim'];

        $horariosIndisponiveis = [];

        $agendamentosMedico = Usuario::findOrFail($request['agendamento']['medico_id'])->agendamentosMedico;

        foreach($agendamentosMedico as $agendamento) {
            $horariosIndisponiveis[] = $agendamento->inicio;
        }

        //verificando se o horário escolhido está disponível
        if(in_array($inicio.':00', $horariosIndisponiveis)) {
            return redirect('/')->with('error', 'Não é possível marcar uma consulta nesta data!');
        }

        if(isset($request['agendamento']['agendamento_id'])) {

            //verificando se já existe um retorno para esta consulta
            $retornoExistente = Agendamento::where('agendamento_id', $request['agendamento']['agendamento_id'])->first();

            //verificando se esta consulta já é um retorno
            $ehUmretorno = Agendamento::findOrFail($request['agendamento']['agendamento_id'])->agendamento_id;

            if($retornoExistente || $ehUmretorno) {
                return redirect('agendamentos')->with('warning', 'Não é possível marcar um retorno para esta consulta.');
            }

            //identificacao de retorno para utilizar no código de check-in
            $codigoRetorno = 1;
        } else {
            $codigoRetorno = 0;
        }

         DB::beginTransaction();
        try{
            $agendamento = Agendamento::create([
                'inicio' => $inicio,
                'fim' => $fim,
                'status_id' => 1,
                'paciente_id' => (int)$request['agendamento']['paciente_id'],
                'medico_id'  => (int)$request['agendamento']['medico_id'],
                'especializacao_id' => (int)$request['agendamento']['especializacao_id'],
                'codigo_check_in' => $request['agendamento']['paciente_id'].$request['agendamento']['especializacao_id'].$request['agendamento']['medico_id'].$codigoRetorno,
            ]);
    
            if(isset($request['agendamento']['agendamento_id'])) {
                $agendamento->update([
                    'agendamento_id' => $request['agendamento']['agendamento_id']
                ]);
            }

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

        if(strtotime(date("Y-m-d H:i:s")) >= $date && $request->input('status_id') == 2) {
            return response()->json(['message' => 'Você não pode cancelar esta consulta!'], 403);
        }
        if(date("Y-m-d") != date('Y-m-d', strtotime( $agendamento->getOriginal('inicio'))) && $request->input('status_id') != 2){
            return response()->json(['message' => 'Você não pode cancelar esta consulta!'], 403);
        }
          
            $pacientes = DB::table('lista_espera')->where('especializacao_id', $agendamento->especializacao_id)->get();
            if($request->input('status_id') == 2 || $request->input('status_id') == 4){
                foreach($pacientes as $paciente){
                    $usuario = \App\Usuario::find($paciente->paciente_id);
                    Mail::to($usuario->email)->send(new ConsultaDisponivel($paciente));
                }            
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
            return response()->json(['message' => 'Status da consulta alterado com sucesso, entre em contato com a clínica para reagendar!'], 200);
        } catch(\Exception $e) {
            return response()->json(['message' => 'Não foi possível alterar o status da consulta'], 500);
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
