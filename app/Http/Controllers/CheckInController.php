<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Agendamento, CheckIn, Log};
use DB;
use Auth;
use Carbon\Carbon;

class CheckInController extends Controller
{

    public function store(Request $request) {

        $agendamento = Agendamento::findOrFail($request->agendamento_id);

        if(!$agendamento) {
            return back()->with('warning', 'Agendamento não encontrado!');
        }

        if($agendamento->status_id != 1) {
            return back()->with('warning', 'Ação não permitida!');
        }

        $dataHoraAtual = Carbon::now();
        $diferencaEmMinutos = Carbon::parse($agendamento->getOriginal('inicio'))->diffInMinutes($dataHoraAtual);

        if($dataHoraAtual < Carbon::parse($agendamento->getOriginal('inicio'))) {
            return back()->with('warning', 'Não é possível realizar o check-in! A data de inicio desta consulta é anterior à data atual.');
        }

        if($diferencaEmMinutos > 60) {
            return back()->with('warning', 'O Check-in só pode ser efetuado no mínimo 1 hora antes da consulta!');
        }

        if($agendamento->checkIn) {
            return $agendamento;
            return back()->with('warning', 'Check-in já efetuado!');
        }

        DB::beginTransaction();
        try {

            $checkIn = CheckIn::create([
                'horario_chegada' => date('Y-m-d H:i:s')
            ]);

            $agendamento->update([
                'check_in_id' => $checkIn->id
            ]);

             
            $client = new \GuzzleHttp\Client();

            $request = $client->request('POST', 'http://localhost:8888/check-in', [
                'form_params' => [
                    'agendamento_id' => $agendamento->id,
                    'medico_id' => $agendamento->medico_id,
                    'especializacao_id' => $agendamento->especializacao_id,
                    'especializacao' => $agendamento->especializacao->especializacao,
                    'nome_paciente' => $agendamento->paciente->nome,
                    'inicio' => $agendamento->inicio
                ]
            ]);

            Log::create([
                'usuario_id' => Auth::user()->id,
                'acao'        => 'Check-in',
                'descricao'   => 'Usuário '.Auth::user()->nome.' efetuou check-in'
            ]); 

            DB::commit();

            return back()->with('success', 'Check-in efetuado com sucesso!');

        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('error', $e);
        }
        
    }
}
