<?php

namespace App\Http\Controllers;
use App\{ Usuario, Horario, Consulta };
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use DB;
use Auth;

class HorarioController extends Controller
{
    public function index()
    {
        $data = [
            'horarios' => Auth::user()->horarios
        ];
  
        return view('usuario.medicos.horario.index', compact('data'));
    }

    public function list(Request $request) {
        $horarios = Auth::user()->horarios()->paginate(10);

        return view('usuario.medicos.horario.table', compact('horarios'));
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
            'url'    => 'medicos/horario',
            'title'  => 'Cadastrar novo horario',
        ];
  
        return view('usuario.medicos.horario.form', compact('data'));
    }

    public function store(Request $request)
    {    
        DB::beginTransaction();
        try{

            Horario::create([
                'inicio' => $request['horario']['inicio'],
                'fim' => $request['horario']['fim'],
                'dia_semana' => $request['horario']['dia_semana'],
                'usuario_id' => Auth::user()->id
            ]);

            DB::commit();
            return redirect('medicos/horario')->with('success', 'horário registrado com sucesso!');
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
