<?php

namespace App\Http\Controllers;
use App\{ Usuario, Horario, Agendamento, DiaSemana, Status, Log, Especializacao };
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\{HorarioCreateRequest};
use DB;
use Auth;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;

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

    public function get($agendamentoId, $diaSemanaId, $horario) {

        $agendamento = Agendamento::findOrFail($agendamentoId);
        $medico = Usuario::findOrFail($agendamento->medico_id);
        $especializacao = Especializacao::findOrFail($agendamento->especializacao_id);

        if($medico->nivel_id !== 3) {
            return back()->with('error', 'O usuário informado não é um médico!');
        }

        $horarios = Horario::where('usuario_id', $medico->id)
            ->where('especializacao_id', $especializacao->id)
            ->where('dias_semana_id', $diaSemanaId)
            ->where('inicio', $horario.':00')
            ->get();

        $diasParaRetorno = $medico->especializacoes()->wherePivot('especializacao_id', $especializacao->id)->first()->pivot->tempo_retorno;

        if($diasParaRetorno == 0) {
            return response()->json(['message' => 'Esta especialização não permite retornos com este médico!'], 403);
        }

        $agendamentoInicio = Carbon::createFromDate($agendamento->getOriginal('inicio'));

        $data = [];

        $count = 0;

        foreach($horarios as $horario) {
            foreach($horario->diasDoMes() as $key => $diaDoMes) {
                $diferencaEmDias = $agendamentoInicio->diffInDays(Carbon::createFromDate($diaDoMes->format('Y-m-d')));
                if($diferencaEmDias < $diasParaRetorno && $diferencaEmDias > 0) {
                    $data[$count]['diaDoMes'] = $diaDoMes->format('d/m/Y');
                    $data[$count]['inicio'] = $horario->inicio;
                    $data[$count]['fim'] = $horario->fim;
                }
                $count++;
            }
        }

        if(!count($data)) {
            return response()->json(['message' => 'não foi encontrado nenhum horário disponível com os parâmetros informados!'], 404);
        }

        return $data;
    }

    public function create()
    {
        $data = [
            'method' => '',
            'button' => 'Enviar',
            'url'    => 'medicos/horario',
            'title'  => 'Cadastrar novo horario',
            'horario' => '',
            'dias'   =>  DiaSemana::all(),
            'especializacoes' => Auth::user()->especializacoes
        ];
  
        return view('usuario.medicos.horario.form', compact('data'));
    } 


    public function store(HorarioCreateRequest $request)
    { 
        
        DB::beginTransaction();
        try{ 
            if($request['horario']['tipo'] == 2){
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
            }else{
                Horario::create([
                    'inicio' => $request['horario']['inicio'],
                    'fim' => $request['horario']['fim'],
                    'dias_semana_id' => $request['horario']['dia_semana'],
                    'usuario_id' => Auth::user()->id,
                    'especializacao_id' => $request['horario']['especializacao_id' ]
                ]);
            }
            DB::commit();
            Log::create([
                'usuario_id' => Auth::user()->id,
                'acao'        => 'Inclusão',
                'descricao'   => 'Usuário '.Auth::user()->nome.' cadastrou um agendadamento'
            ]);
            return redirect('medicos/horario')->with('success', 'Horário registrado com sucesso!');
         }catch(\Exception $e){
            DB::rollback();
            return back()->with('error', 'Erro no servidor');
        }
     
    }

    public function show($id){}

    public function edit($id)
    {

        $horario = Horario::findOrFail($id);

        $data = [
            'method' => 'PUT',
            'button' => 'Atualizar',
            'url'    => 'medicos/horario/'.$id,
            'title'  => 'Editar horario',
            'horario' => $horario,
            'dias'   =>  DiaSemana::all(),
            'especializacoes' => Auth::user()->especializacoes
        ];
  
        return view('usuario.medicos.horario.form', compact('data'));
    }

    public function update(HorarioCreateRequest $request, $id)
    {
        $horario = Horario::findOrFail($id);

        DB::beginTransaction();
        try {
            $horario->update([
                'inicio' => $request['horario']['inicio'],
                'fim'   => $request['horario']['fim'],
                'usuario_id' => Auth::user()->id,
                'dias_semana_id' => $request['horario']['dia_semana'],
                'especializacao_id' => $request['horario']['especializacao_id']
            ]);

            DB::commit();
            Log::create([
                'usuario_id' => Auth::user()->id,
                'acao'       => 'Alteração', 
                'descricao'  => 'Usuário '.Auth::user()->nome.' alterou um agendadamento'
            ]);
            return redirect('medicos/horario')->with('success', 'Horário atualizado com sucesso!');
        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro no servidor');
        }
    }

    public function destroy($id)
    {
        $horario = Horario::withTrashed()->findOrFail($id);
        if($horario->trashed()) {
            $horario->restore();
            Log::create([
                'usuario_id' => Auth::user()->id,
                'acao'       => 'Ativação', 
                'descricao'  => 'Usuário '.Auth::user()->nome.' reativou um agendadamento'
            ]);
            return back()->with('success', 'Horario ativado com sucesso!');
        } else {
            $horario->delete();
            Log::create([
                'usuario_id' => Auth::user()->id,
                'acao'       => 'Exlusão', 
                'descricao'  => 'Usuário '.Auth::user()->nome.' deletou um agendadamento'
            ]);
            return back()->with('success', 'Horario desativado com sucesso!');
        }
    }
}
