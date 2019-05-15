<?php

namespace App\Http\Controllers;

use App\{Usuario, Nivel, Estado, Cidade, Endereco, Telefone, Especializacao};
use DB;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    public function listar($nivel) {
        $usuarios = Usuario::where('nivel_id', $nivel)->get();

        return view('usuario.index', compact('usuarios'));
    }

   
    public function create()
    {

        $data = [
            'usuario' => '',
            'method' => '',
            'url' => 'usuario',
            'title' => 'Cadastro de Usuário',
            'niveis' => Nivel::all(),
            'estados' => Estado::all(),
            'cidades' => Cidade::all(),
            'especializacoes' => Especializacao::all(),
            'especializacoes_usuario' => [new Especializacao],
            'telefones' => [new Telefone]
        ];

        return view('usuario.form', compact('data'));
    }

   
    public function store(Request $request)
    {
        if($request['usuario']['password'] !== $request['usuario']['password_confirmation']) {
            return back()->with('warning', 'As senhas informadas devem ser iguais!');
        }

        DB::beginTransaction();
        try {

            $usuario = Usuario::create($request['usuario']);
            $usuario->endereco()->save(new Endereco($request['endereco']));
            $usuario->especializacoes()->attach($request['especializacoes']);

            foreach($request['telefone'] as $telefone) {
                $usuario->telefones()->save(new Telefone([ 'numero' => $telefone['numero'] ]));
            }

            DB::commit();

            return back()->with('success', 'Usuário cadastrado com sucesso!');

        } catch(Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Erro no servidor!');

        }

    }

   
    public function show($id)
    {
        
    }

    public function edit($id)
    {

        $usuario = Usuario::findOrFail($id);

        $data = [
            'usuario' => $usuario,
            'method' => 'PUT',
            'url' => 'usuario/'.$id,
            'title' => 'Cadastro de Usuário',
            'niveis' => Nivel::all(),
            'estados' => Estado::all(),
            'cidades' => Cidade::all(),
            'especializacoes' => Especializacao::all(),
            'especializacoes_usuario' => count($usuario->especializacoes) ? $usuario->especializacoes : [new Especializacao],
            'telefones' => count($usuario->telefones) ? $usuario->telefones : [new Telefone]
        ];

        return view('usuario.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validatedData = $request->validate([
            'usuario.nome' => 'required|min:5',
        ]);

        DB::beginTransaction();
        try {

            $usuario->update($request->input('usuario'));
            $usuario->endereco->update($request->input('endereco'));
            $usuario->especializacoes()->sync($request['especializacoes']);
      
            foreach($request->input('telefone') as $telefone){
                if($telefone['id'])
                    Telefone::find($telefone['id'])->update($telefone);
                else {
                    $usuario->telefones()->save(new Telefone($telefone));
                }
            }

            DB::commit();

            return back()->with('success', 'Usuário cadastrado com sucesso!');

        } catch(Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Erro no servidor!');

        }

    }

    
    public function destroy($id)
    {
        
    }
}
