<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{StatusAgendamento, Agendamento};

class RelatorioController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Relatórios',
            'agendamentos' => [
                'confirmados' => Agendamento::where("status_id", 1)->count(),
                'cancelados' => Agendamento::where("status_id", 2)->count(),
                'naoCompareceu' => Agendamento::where("status_id", 3)->count(),
                'finalizados' => Agendamento::where("status_id", 4)->count(),
            ]
        ];
        return view('relatorio.index', compact('data'));
    }
}
