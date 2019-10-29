<?php

namespace App\Http\Controllers;

use App\{Usuario, Nivel, Agendamento, Especializacao, Horario, DiaSemana};
use Illuminate\Http\Request;
use App\Http\Resources\UsuarioCollection;
use App\Http\Requests\{AgendamentoCreateRequest};
use DB;
use Auth;

class AgendamentoController extends Controller
{
    public function index()
    {
        //
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
        return view('usuario.pacientes.agendamento', compact('data'));
    }

    public function confirma($id){
        $data = [
            'method'  => '',
            'button'  => 'Confirmar',
            'url'     => 'atendente/agendamento/',
            'title'   => 'Confirmação de agendamento de consulta',
            'horario' => Horario::find($id),
        ];
        return view('usuario.pacientes.confirmacao', compact('data'));
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
            Agendamento::create([
                'inicio' => $inicio,
                'fim' => $fim,
                'paciente_id' => (int)$request['paciente_id'],
                'medico_id'  => (int)$request['medico_id'],
                'especializacao_id' => (int)$request['especializacao_id'],
                'codigo_check_in' => $request['paciente_id'].$request['especializacao_id'].$request['medico_id'],
            ]);

            DB::commit();
            return back()->with('success', 'Consulta Marcada com sucesso');
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
        return view('usuario.pacientes.resultados', compact('horarios'));
    }



    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $agendamento = Agendamento::whereId($id)->update($request->except(['_method', '_token']));
        return back();
    }

    public function setStatus(Request $request, $id){
      
        $agendamento = Agendamento::whereId($id)->update(['status_id' => $request->input('status_id')]);
       
    }

    public function destroy($id)
    {
        $agendamento = Agendamento::find($id);
        if(date($agendamento->inicio, strtotime('-24 hours', time()))){
            $agendamento->delete();    
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
