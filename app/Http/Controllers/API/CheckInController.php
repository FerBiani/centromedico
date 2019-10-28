<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Events\CheckInEfetuado;
use App\Http\Controllers\Controller;
use App\{Agendamento, CheckIn};
use DB;

class CheckInController extends Controller
{

    public function store(Request $request) {

        $agendamento = Agendamento::where('codigo_check_in', $request->codigo);

        if(!$agendamento->first()) {
            return response()->json([
                'message' => 'Agendamento não encontrado!'
            ], 404);
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

            DB::commit();

            $client = new \GuzzleHttp\Client();

            $request = $client->request('POST', 'http://localhost:8888/check-in', [
                'form_params' => [
                    'agendamento_id' => $agendamento->first()->id,
                    'medico_id' => $agendamento->first()->medico_id,
                ]
            ]);

            return response()->json([
                'message' => 'Check-in efetuado com sucesso!',
            ], 200);

        } catch(\Exception $e) {
            DB::rollback();
            return response()->json($e, 500);
        }
        
    }
}
