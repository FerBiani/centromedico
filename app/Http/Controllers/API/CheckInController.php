<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Events\CheckInAgendamento;
use App\Http\Controllers\Controller;
use App\{Agendamento, CheckIn};
use DB;

class CheckInController extends Controller
{

    public function store(Request $request) {

        $agendamento = Agendamento::where('codigo_check_in', $request->codigo);

        if(!$agendamento->first()) {
            return response()->json('Agendamento não encontrado!', 404);
        }

        if($agendamento->first()->checkIn) {
            return response()->json('Check-in já efetuado!', 409);
        }

        DB::beginTransaction();
        try {
            $checkIn = CheckIn::create([
                'horario_chegada' => date('Y-m-d H:i:s')
            ]);

            $agendamento->update([
                'check_in_id' => $checkIn->id
            ]);

            DB::commit();
            return response()->json('Check-in efetuado com sucesso!', 200);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json('Erro no servidor!', 500);
        }
        
    }
}
