<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Especializacao;
use App\Http\Requests\EspecializacaoRequest;
use DB;

class EspecializacaoController extends Controller
{
    public function index()
    {
        $especializacoes = Especializacao::paginate(10);

        return view('especializacoes.index', compact('especializacoes'));
    }

    public function create()
    {
        $data = [
            'especializacao' => '',
            'method' => '',
            'button' => 'Cadastrar',
            'url' => 'especializacoes',
            'title' => 'Cadastro de Especialização',
        ];

        return view('especializacoes.form', compact('data'));
    }

    public function store(EspecializacaoRequest $request)
    {
        DB::beginTransaction();
        try {

            Especializacao::create($request->input('especializacao'));

            DB::commit();
            return redirect('especializacoes')->with('success', 'Especialização cadastrada com sucesso!');

        } catch(\Exception $e) {
            DB::rollback();
            return redirect('/')->with('error', 'Erro no servidor!');
        }
    }

    public function edit($id)
    {

        $especializacao = Especializacao::findOrFail($id);

        $data = [
            'especializacao' => $especializacao,
            'method' => 'PUT',
            'button' => 'Atualizar',
            'url' => 'especializacoes/'.$id,
            'title' => 'Atualização de Especialização',
        ];

        return view('especializacoes.form', compact('data'));
    }

    public function update(EspecializacaoRequest $request, $id)
    {
        $especializacao = Especializacao::findOrFail($id);

        try {

            $especializacao->update($request->input('especializacao'));

            DB::commit();
            return redirect('especializacoes')->with('success', 'Especialização atualizada com sucesso!');

        } catch(\Exception $e) {
            DB::rollback();
            return redirect('/')->with('error', 'Erro no servidor!');
        }

    }

    public function destroy($id)
    {
        $especializacao = Especializacao::findOrFail($id);

        if($especializacao->usuarios()->first()) {
            return back()->with('warning', 'Não é possível excluir esta especializacao pois existem médicos vinculados à ela.');
        }

        $especializacao->delete();
        Log::create([
            'usuario_id'  => Auth::user()->id,
            'acao'        => 'Exclusão',
            'descricao'   => 'Usuário '.Auth::user()->nome.' deletou uma especialização'
        ]); 
        return back()->with('success', 'Especialização deletada com sucesso!');
    }
}
