<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class AtestadoController extends Controller
{
    public function show($id){
        $paciente = Usuario::findOrFail($id);
        return view('impressos.atestado', compact('paciente'));
    }
}
