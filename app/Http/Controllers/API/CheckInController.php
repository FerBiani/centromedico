<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Events\CheckInEfetuado;
use App\Http\Controllers\Controller;
use App\{Agendamento, CheckIn};
use DB;
use Carbon\Carbon;

class CheckInController extends Controller
{

    public function store(Request $request) {

        $agendamento = Agendamento::where('codigo_check_in', $request->codigo);

        if(!$agendamento->first()) {
            return response()->json([
                'message' => 'Agendamento não encontrado!'
            ], 404);
        }

        if($agendamento->first()->status_id != 1) {
            return response()->json([
                'message' => 'Ação não permitida!'
            ], 409);
        }

        $dataHoraAtual = Carbon::now();
        $diferencaEmMinutos = Carbon::parse($agendamento->first()->getOriginal('inicio'))->diffInMinutes($dataHoraAtual);

        if($dataHoraAtual > Carbon::parse($agendamento->first()->getOriginal('inicio'))) {
            return response()->json([
                'message' => 'Não é possível realizar o check-in! A data de inicio desta consulta é anterior à data atual.'
            ], 409);
        }

        if($diferencaEmMinutos > 60) {
            return response()->json([
                'message' => 'O Check-in só pode ser efetuado no mínimo 1 hora antes da consulta!'
            ], 409);
        }

        if($agendamento->first()->checkIn) {
            return response()->json([
                'message' => 'Check-in já efetuado!'
            ], 409);
        }

        DB::beginTransaction();
        try {
            $checkIn = CheckIn::create([
                'horario_chegada' => date('Y-m-d H:i:s')
            ]);

            $agendamento->update([
                'check_in_id' => $checkIn->id
            ]);

            //event(new CheckInEfetuado(Agendamento::findOrFail($agendamento->first()->id)));
            
            $client = new \GuzzleHttp\Client();

            $request = $client->request('POST', 'http://localhost:8888/check-in', [
                'form_params' => [
                    'agendamento_id' => $agendamento->first()->id,
                    'medico_id' => $agendamento->first()->medico_id,
                    'especializacao_id' => $agendamento->first()->especializacao_id,
                    'especializacao' => $agendamento->first()->especializacao->especializacao,
                    'nome_paciente' => $agendamento->first()->paciente->nome,
                    'inicio' => $agendamento->first()->inicio
                ]
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Check-in efetuado com sucesso!',
            ], 200);

        } catch(\Exception $e) {
            DB::rollback();
            return response()->json($e, 500);
        }
        
    }
}
