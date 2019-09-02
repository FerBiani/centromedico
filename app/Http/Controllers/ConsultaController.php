<?php

namespace App\Http\Controllers;

use App\{Usuario, Nivel, Consulta, Especializacao };
use Illuminate\Http\Request;
use App\Http\Requests\{ConsultaCreateRequest};
use DB;
use Auth;

class ConsultaController extends Controller
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
            'url'    => 'pacientes/consulta',
            'title'  => 'Agendamento de Consultas',
            'especializacoes' => Especializacao::all(),
            'usuarios' => Usuario::withCount('especializacoes')->get()
        ];
        return view('usuario.pacientes.agendamento', compact('data'));
    }

    public function store(ConsultaCreateRequest $request)
    {   
        DB::beginTransaction();
        try{
            $consulta = Consulta::create($request->all());
            $consulta->paciente_id = auth::user()->id;
            DB::commit();
            return back()->with('success', 'Consulta Marcada com sucesso');
        }catch(\Exception $e){
            DB::rollback();
            return back()->with('error', 'Erro ao agendar a consulta');
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
        $consulta = Consulta::whereId($id)->update($request->except(['_method', '_token']));
        return back();
    }

    public function destroy($id)
    {
        //
    }
}
