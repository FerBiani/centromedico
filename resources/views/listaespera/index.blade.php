@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Lista de Espera de Consultas</div>
            <div class="card-body">  
            <div class="row mb-4">
                <div class="col-md-6">
                    <form id="form-pesquisa">
                        <div class="input-group">
                            <input name="pesquisa" placeholder="Pesquisa..." class="form-control" type="text"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-dark"><i class="fas fa-search" style="margin: 5px"></i> Pesquisar</button>
                    </div>
                    </form>
                    <div class="col-md-3">
                        <a href="{{url('lista/create')}}"><button class="btn btn-success">Adicionar Paciente</button></a>
                    </div>
                </div>
            <div class="tab-content" id="myTabContent">
                <div class="table-responsive">
                    <table id="horario-table" class="table table-hover">
                        <thead class="thead thead-light">
                            <tr>
                                <th>Nome</th>
                                <th>Dia Semana</th>
                                <th>Especialização</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['dados'] as $dado)
                                <tr>
                                    <td>{{\App\Usuario::find($dado->paciente_id)->nome}}</td>
                                    <td>{{\App\DiaSemana::find($dado->dia_semana_id)->dia}}</td>
                                    <td>{{ \App\Especializacao::find($dado->especializacao_id)->especializacao }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                 </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection