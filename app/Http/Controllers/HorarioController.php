<?php

namespace App\Http\Controllers;
use App\{ Usuario, Horario, Agendamento, DiaSemana };
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use DB;
use Auth;
use DateTime;
use DatePeriod;
use DateInterval;

class HorarioController extends Controller
{
    public function index()
    {
        $data = [
            'horarios' => Auth::user()->horarios,
            'dias' => DiaSemana::All()
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
            'consultas' => Agendamento::where('medico_id',auth::user()->id)
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
            'dias'   =>  DiaSemana::all(),
            'especializacoes' => Auth::user()->especializacoes
        ];
  
        return view('usuario.medicos.horario.form', compact('data'));
    } 


    public function store(Request $request)
    { 
        DB::beginTransaction();
        try{ 
            $inicio = new DateTime($request['horario']['inicio']);
            $fim = new DateTime($request['horario']['fim']);

            $intervalo = DateInterval::createFromDateString($request['horario']['duracao'].' min');
            $horarios = new DatePeriod($inicio, $intervalo, $fim);
            foreach ($horarios as $horarios) {
                Horario::create([
                    'inicio' => $horarios->format('H:i'),
                    'fim' => $horarios->add($intervalo)->format('H:i'),
                    'dias_semana_id' => $request['horario']['dia_semana'],
                    'usuario_id' => Auth::user()->id,
                    'especializacao_id' => $request['horario']['especializacao_id' ]
                ]);
            }
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
        $horario = Horario::findOrFail($id);
        $horario->delete();
        return back();
    }
}
