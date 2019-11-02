<?php

namespace App\Http\Controllers;
use App\{Log};
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Logs',
            'logs'  => Log::paginate(10)
        ];
        return view('logs.index', compact('data'));
    }

    public function list(Request $request){
        $logs = new Log;

        if($request['pesquisa']) {
            $logs = $logs->where('descricao', 'like', '%'.$request['pesquisa'].'%');
        }

        if($request['acao']) {
            $logs = $logs->where('acao', 'like', '%'.$request['acao'].'%');
        }

        $logs = $logs->paginate(10);
        
        return view('logs.table', compact('logs'));
    }
}
