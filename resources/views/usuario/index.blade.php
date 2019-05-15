@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group"/>
                            <input class="form-control" type="text"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th colspan="5">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{$usuario->nome}}</td>
                            <td>{{$usuario->telefones->first()->numero}}</td>
                            <td>{{$usuario->email}}</td>
                            <td><a class="btn btn-warning" href="{{url('usuario/'.$usuario->id.'/edit')}}">Editar</a></td>
                            <td><a class="btn btn-danger" href="#">Excluir</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection