<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->nivel_id <= 1){
            //admin
            return redirect('relatorios');
         }elseif(Auth::user()->nivel_id == 2){
            //paciente
             return redirect('pacientes/ficha');
         }elseif(Auth::user()->nivel_id == 3){
            //medico
             return redirect('medicos/horario');
         }else{
            //atendente
             return redirect('usuario');
         }

        
    }
}
