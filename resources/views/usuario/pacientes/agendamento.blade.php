@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>
            <div class="card-body">            
                <form id="form" method="POST" action="{{url($data['url'])}}">
                    @csrf
                    @if($data['method'])
                        @method($data['method'])
                    @endif
                    <h6>Dados da agendamento</h6>
                    <div class="form-group row">
                        <label for="agendamento[especializacoes_id]" class="col-md-4 col-form-label text-md-right">Especialização Desejada</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control especialidade" name="especializacoes_id">
                                    <option value="">Selecione</option>
                                    @foreach($data['especializacoes'] as $especializacao)
                                        <option data-especializacao="{{$especializacao->especializacao}}" value="{{$especializacao->id}}">{{$especializacao->especializacao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacoes.nome') }}</small>
                    </div> 

                    <div class="form-group row">
                        <label for="agendamento[medico_id]" class="col-md-4 col-form-label text-md-right">Médico Desejado</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control medicos" name="medico_id" id="medicos_id">
                                    @foreach($data['usuarios'] as $usuario)
                                         <option data-medico="{{$usuario->id}}" value="{{ $usuario->id }}">Selecione</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('medicos') }}</small>
                    </div>

                    <h6>Dados da Data da agendamento</h6>
                    <div class="form-group row">
                        <label for="agendamento[data]" class="col-md-4 col-form-label text-md-right data">Data da agendamento</label>
                        <div class="col-md-6">
                            <select class="form-control dias" name="data" id="data">
                                @foreach($data['periodos'] as $periodo)
                                        <option data-dia="{{$periodo->dia_semana}}" value="{{ $periodo->dia_semana }}">Selecione</option>
                                @endforeach
                            </select>
                            <!-- <input id="nome" type="date" class="form-control" name="data" > -->
                            <small id="error" class="errors font-text text-danger">{{$errors->first('data')}}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="agendamento[hora]" class="col-md-4 col-form-label text-md-right">Horas Disponíveis </label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control horas" name="hora" id="medicos_id">
                                    @foreach($data['periodos'] as $periodo)
                                         <option value="{{ $periodo->inicio }}">Selecione</option>
                                    @endforeach
                                </select>
                            <!-- <input id="nome" type="time" class="form-control" name="hora" > -->
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{$errors->first('hora')}}</small>
                    </div>
                </div>
                <input type="hidden" name="paciente_id" value="{{ auth::user()->id }}">
            </div>
        </div>
        </form>
        </div>
            <div class="card-footer">
                <div class="form-group row mb-0">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success send-form">
                            {{$data['button']}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
@stop