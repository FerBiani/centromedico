<?php

namespace App\Http\Controllers;
use App\{ Usuario, Periodo, Consulta };
use Illuminate\Http\Request;
use DB;
use Auth;

class PeriodoController extends Controller
{
    public function index()
    {
        //
    }

    public function consultas(){
        /**
         * consultas marcadas, e o usuarios.
         */
        $data = [
            'title' => 'Consultas Agendadas',
            'consultas' => Consulta::where('medico_id',auth::user()->id)
        ];

        return view('usuario.medicos.consultas', compact('data'));
    }

    public function create()
    {
        $data = [
            'method' => '',
            'button' => 'Enviar',
            'url'    => 'medicos/periodo',
            'title'  => 'Períodos Disponíveis',
        ];
  
        return view('usuario.medicos.horarios', compact('data'));
    }

    public function store(Request $request)
    {
         DB::beginTransaction();
         try{
            $periodo = Periodo::create($request->all());
            $periodo->usuarios_id = auth::user()->id;
             DB::commit();
             return back()->with('success', 'Período de trabalho registrado com sucesso');
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
        //
    }

    public function destroy($id)
    {
        //
    }
}
