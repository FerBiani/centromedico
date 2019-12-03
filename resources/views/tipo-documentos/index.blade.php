@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">Usuários</div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-12 text-right">
                        <a class="btn btn-dark" href="{{url('tipo-documentos/create')}}">Novo</a>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead class="thead thead-light">
                        <tr>
                            <th>Tipo</th>
                            <th>Possui complemento?</th>
                            <th colspan="3" class="min">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tiposDocumento as $tipoDocumento)
                            <tr>
                                <td>{{$tipoDocumento->tipo}}</td>
                                <td>{{$tipoDocumento->possui_complemento ? 'Sim' : 'Não'}}</td>
                                <td class="min"> 
                                    <a class="btn btn-warning text-white" href='{{ url("tipo-documentos/$tipoDocumento->id/edit") }}'>Editar</a>
                                </td>
                                <td class="min"> 
                                    <form action="{{url('tipo-documentos', [$tipoDocumento->id])}}" class="input-group" method="POST">
                                        {{method_field('DELETE')}}
                                        {{ csrf_field() }}
                                        <input type="submit" class="btn btn-danger" value="Deletar"/>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection