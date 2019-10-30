<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Agendamento, CheckIn};
use DB;

class CheckInController extends Controller
{

    public function store(Request $request) {

        $agendamento = Agendamento::findOrFail($request->agendamento_id);

        if(!$agendamento->first()) {
            return back()->with('warning', 'Agendamento não encontrado!');
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

            DB::commit();

            return back()->with('success', 'Check-in efetuado com sucesso!');

        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro no servidor');
        }
        
    }
}
