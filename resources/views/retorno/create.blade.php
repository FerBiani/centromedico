@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>   
            <div class="card-body">
                <form id="form" method="post" action="{{url($data['url'])}}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="agendamento[inicio]" class="col-form-label">Paciente</label>
                            <div class="input-group">
                                <input readonly id="inicio" type="text" class="form-control especialidade" name="inicio" value="{{ \App\Usuario::findOrFail($data['consulta']->paciente_id)->nome }}">
                                <input type="hidden"  name="paciente_id" value="{{ \App\Usuario::findOrFail($data['consulta']->paciente_id)->id }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.inicio') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-form-label">Médico</label>
                            <div class="input-group">
                                <input readonly id="fim" type="text" class="form-control" id="validationCustom01" name="fim" value="{{ \App\Usuario::findOrFail($data['consulta']->medico_id)->nome }}">
                                <input type="hidden"  name="medico_id" value="{{ \App\Usuario::findOrFail($data['consulta']->medico_id)->id }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.fim') }}</small>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="" class="col-form-label">Especialização</label>
                            <div class="input-group">
                                <input readonly type="text" class="form-control" value="{{ \App\Especializacao::findOrFail($data['consulta']->especializacao_id)->especializacao }}">
                                <input type="hidden"  name="especializacao_id" value="{{ \App\Especializacao::findOrFail($data['consulta']->especializacao_id)->id }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.especializacao') }}</small>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="" class="col-form-label">Dia</label>
                        <select id="select-data" class="form-control" name="data">
                            @foreach($data['horarios']->diasDoMes() as $dia)
                                <option>{{$dia->format('d/m/Y')}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden"  name="consulta_id" value="{{ $data['consulta']->id }}">
                <div class="card-footer">
                    <div class="form-group row mb-0">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-success send-form">
                                {{$data['button']}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
