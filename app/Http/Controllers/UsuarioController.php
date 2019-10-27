<?php

namespace App\Http\Controllers;

use App\{Usuario, Nivel, Estado, Endereco, Telefone, Especializacao, Documento, TipoDocumento};
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\{UsuarioCreateRequest, UsuarioUpdateRequest};
use DB;
use Auth;

class UsuarioController extends Controller
{

    public function index() {
        $usuarios = Usuario::paginate(10);

        if(Auth::user()->nivel_id == 1) {
            $niveis = Nivel::all();
        } else {
            $niveis = Nivel::where('id', 2)->get();
        }

        return view('usuario.index', compact('usuarios', 'niveis'));
    }

    public function list(Request $request, $status) {
        $usuarios = new Usuario;

        if(Auth::user()->nivel_id == 1) {
            $usuarios = $usuarios->where('nivel_id', '>', '1');
        } else {
            $usuarios = $usuarios->where('nivel_id', 2);
        }

        if($request['pesquisa']) {
            $usuarios = $usuarios->where('nome', 'like', '%'.$request['pesquisa'].'%');
        }

        if($request['nivel'] !== 'all') {
            $usuarios = $usuarios->where('nivel_id', 'like', '%'.$request['nivel'].'%');
        }

        if($status == 'inativos'){
            $usuarios = $usuarios->onlyTrashed();
        }

        $usuarios = $usuarios->paginate(10);

        return view('usuario.table', compact('usuarios', 'status'));
    }

   
    public function create()
    {

        $data = [
            'usuario' => '',
            'method' => '',
            'button' => 'Cadastrar',
            'url' => 'usuario',
            'title' => 'Cadastro de Usuário',
            'niveis' => Nivel::all(),
            'estados' => Estado::all(),
            'especializacoes' => Especializacao::all(),
            'documentos' => [new Documento],
            'especializacoes_usuario' => [new Especializacao],
            'telefones' => [new Telefone],
            'tipoDocumentos' => TipoDocumento::all()
        ];

        return view('usuario.form', compact('data'));
    }

   
public function store(UsuarioCreateRequest $request)
    {
        if($request['usuario']['password'] !== $request['usuario']['password_confirmation']) {
            return back()->with('warning', 'As senhas informadas devem ser iguais!');
        }   
        DB::beginTransaction();
        try {
            $usuario = Usuario::create($request['usuario']);
            $usuario->endereco()->save(new Endereco($request['endereco']));
            $usuario->especializacoes()->attach($request['especializacoes']);
            
            foreach($request['documento'] as $documento) {
                $usuario->documentos()->save(new Documento([ 'numero' => $documento['numero'], 'tipo_documentos_id' => $documento['tipo_documentos_id'] ]));
            }
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
            'button' => 'Atualizar',
            'url' => 'usuario/'.$id,
            'title' => 'Cadastro de Usuário',
            'niveis' => '',
            'estados' => Estado::all(),
            'especializacoes' => Especializacao::all(),
            'especializacoes_usuario' => count($usuario->especializacoes) ? $usuario->especializacoes : [new Especializacao],
            'telefones' => count($usuario->telefones) ? $usuario->telefones : [new Telefone],
            'documentos' => count($usuario->documentos) ? $usuario->documentos : [new Documento]
        ];

        return view('usuario.form', compact('data'));
    }

    public function update(UsuarioUpdateRequest $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        DB::beginTransaction();
        try {

            $usuario->update($request->input('usuario'));
            $usuario->endereco->update($request->input('endereco'));
            $usuario->especializacoes()->sync($request['especializacoes']);

            foreach($request->input('documento') as $documento){
                if($documento['id'] !== null)
                    Documento::find($documento['id'])->update($documento);
                else {
                    $usuario->documentos()->save(new Documento($documento));
                }
            }
      
            foreach($request->input('telefone') as $telefone){
                if($telefone['id'] !== null)
                    Telefone::find($telefone['id'])->update($telefone);
                else {
                    $usuario->telefones()->save(new Telefone($telefone));
                }
            }

            DB::commit();

            return back()->with('success', 'Usuário atualizado com sucesso!');

        } catch(Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Erro no servidor!');
        }
    }

    public function destroy($id)
    {
        $usuario = Usuario::withTrashed()->findOrFail($id);
        if($usuario->trashed()) {
            $usuario->restore();
            return back()->with('success', 'Usuário ativado com sucesso!');
        } else {
            $usuario->delete();
            return back()->with('success', 'Usuário desativado com sucesso!');
        }
    }

    public function getCidades($uf) {
        $estado = Estado::where('uf', $uf)->first();
        return $estado ? $estado->cidades()->select('id','nome')->get() : [];
    }

    public function getMedicos($especializacao){
        $especializacao = Especializacao::where('especializacao', $especializacao)->first();
        return $especializacao ? $especializacao->usuarios()->select('id','nome')->get() : [];
    }

}
