@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">Especializações</div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-12 text-right">
                        <a class="btn btn-dark" href="{{url('especializacoes/create')}}">Nova</a>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead class="thead thead-light">
                        <tr>
                            <th>Nome</th>
                            <th colspan="2" class="min">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($especializacoes as $especializacao)
                            <tr>
                                <td>{{$especializacao->especializacao}}</td>
                                <td class="min"> 
                                    <a class="btn btn-warning text-white" href='{{ url("especializacoes/$especializacao->id/edit") }}'>Editar</a>
                                </td>
                                <td class="min"> 
                                    <form action="{{url('especializacoes', [$especializacao->id])}}" class="input-group" method="POST">
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