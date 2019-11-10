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

        if(!$agendamento->first()) {
            return back()->with('warning', 'Agendamento não encontrado!');
        }

        if($agendamento->first()->status_id != 1) {
            return back()->with('warning', 'Ação não permitida!');
        }

        $dataHoraAtual = Carbon::now();
        $diferencaEmMinutos = Carbon::parse($agendamento->first()->getOriginal('inicio'))->diffInMinutes($dataHoraAtual);

        if($diferencaEmMinutos > 60) {
            return back()->with('warning', 'O Check-in só pode ser efetuado no mínimo 1 hora antes da consulta!');
        }

        if($agendamento->first()->checkIn) {
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

            Log::create([
                'usuario_id' => Auth::user()->id,
                'acao'        => 'Check-in',
                'descricao'   => 'Usuário '.Auth::user()->nome.' efetuou check-in'
            ]); 

            DB::commit();

            return back()->with('success', 'Check-in efetuado com sucesso!');

        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro no servidor');
        }
        
    }
}
