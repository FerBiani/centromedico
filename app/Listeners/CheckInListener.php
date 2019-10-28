<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\CheckInEfetuado;

class CheckInListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CheckInEfetuado $event)
    {
        try {

            $agendamento = $event->agendamento;

            $agendamento->codigo_check_in = '0000';
            $agendamento->save();

            // $client = new \GuzzleHttp\Client();

            // $request = $client->post('http://localhost:8888/check-in', [
            //     'agendamento' => [
            //         'id' => '2'
            //     ]
            // ]);

            // $response = $request->send();
            
            // if($codeHttp != 200){
            //     return $response;
            // }
            // else{
            //     return false;
            // }       
        }
        catch(Exception $e){
            return $e;
        }
    }
}
