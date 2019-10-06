<?php

namespace App\Http\Controllers;

use App\{Usuario, Nivel, Agendamento, Especializacao, Horario };
use Illuminate\Http\Request;
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
            'button' => 'Agendar',
            'url'    => 'pacientes/agendamento',
            'title'  => 'Agendamento de Consultas',
            'especializacoes' => Especializacao::all(),
            'usuarios' => Usuario::withCount('especializacoes')->get(),
            'horarios' => Horario::all(),
        ];
        return view('usuario.pacientes.agendamento', compact('data'));
    }

    public function store(Request $request)
    {   
        DB::beginTransaction();
        try{
            $agendamento = Agendamento::create($request->all());
            $agendamento->paciente_id = auth::user()->id;
            DB::commit();
            return back()->with('success', 'Consulta Marcada com sucesso');
        }catch(\Exception $e){
            DB::rollback();
            return back()->with('error', $e);
        }
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

    public function destroy($id)
    {
        //
    }

    public function getDisponibilidade($medico){
        $disponibilidades = Periodo::where('usuarios_id',$medico)->first();
        //return $disponibilidades->id;
        echo $disponibilidades;
    }

    public function getDias($medico){
        $dias = Periodo::where('usuarios_id', $medico)->get();
        echo $dias;
    }
}
