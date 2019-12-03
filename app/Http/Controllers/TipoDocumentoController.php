<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{TipoDocumento, Log};
use App\Http\Requests\TipoDocumentoRequest;
use DB;
use Auth;

class TipoDocumentoController extends Controller
{
    public function index()
    {
        $tiposDocumento = TipoDocumento::paginate(10);

        return view('tipo-documentos.index', compact('tiposDocumento'));
    }

    public function create()
    {
        $data = [
            'tipoDocumento' => '',
            'method' => '',
            'button' => 'Cadastrar',
            'url' => 'tipo-documentos',
            'title' => 'Cadastro de Tipo de Documento',
        ];

        return view('tipo-documentos.form', compact('data'));
    }

    public function store(TipoDocumentoRequest $request)
    {
        DB::beginTransaction();
        try {

            TipoDocumento::create($request->input('tipo_documentos'));

            DB::commit();
            return redirect('tipo-documentos')->with('success', 'Tipo de documento cadastrado com sucesso!');

        } catch(\Exception $e) {
            DB::rollback();
            return redirect('/')->with('error', 'Erro no servidor!');
        }
    }

    public function edit($id)
    {

        $tipoDocumento = TipoDocumento::findOrFail($id);

        $data = [
            'tipoDocumento' => $tipoDocumento,
            'method' => 'PUT',
            'button' => 'Atualizar',
            'url' => 'tipo-documentos/'.$id,
            'title' => 'Atualização de Tipo de Documento',
        ];

        return view('tipo-documentos.form', compact('data'));
    }

    public function update(TipoDocumentoRequest $request, $id)
    {
        $tipoDocumento = TipoDocumento::findOrFail($id);

        try {

            $tipoDocumento->update($request->input('tipo_documentos'));

            DB::commit();
            return redirect('tipo-documentos')->with('success', 'Tipo de documento atualizado com sucesso!');

        } catch(\Exception $e) {
            DB::rollback();
            return redirect('/')->with('error', 'Erro no servidor!');
        }

    }

    public function destroy($id)
    {
        $tipoDocumento = TipoDocumento::findOrFail($id);

        if($tipoDocumento->documentos()->first()) {
            return back()->with('warning', 'Não é possível excluir este tipo de documento pois existem documentos vinculados à ele.');
        }

        $tipoDocumento->delete();
        Log::create([
            'usuario_id' => Auth::user()->id,
            'acao'        => 'Exclusão',
            'descricao'   => 'Usuário '.Auth::user()->nome.' deletou um tipo de documento'
        ]); 
        return back()->with('success', 'Tipo de documento deletado com sucesso!');
    }
}
