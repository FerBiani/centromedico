<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use auth;

class PacienteController extends Controller
{
    
    public function index(){
        $data = [
            'title'   => 'Ficha Paciente',
            'usuario' =>  Usuario::find(Auth::user()->id),
        ];
        return view('usuario.pacientes.ficha', compact('data'));
    }
}
