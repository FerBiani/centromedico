@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>
            <div class="card-body">
                <form id="form_agendamento" method="POST" action="{{url($data['url'])}}">
                    @csrf
                    @if($data['method'])
                        @method($data['method'])
                    @endif
                    <h6>Dados da Consulta</h6>
                    <div class="form-group row">
                        <label for="especializacoes[nome]" class="col-md-4 col-form-label text-md-right">Especialização Desejada</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control especialidade" name="especializacao_id">
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
                        <label for="usuario[nome]" class="col-md-4 col-form-label text-md-right">Médico Desejado</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control medicos" name="usuario_id" id="medicos_id">
                                    @foreach($data['usuarios'] as $usuario)
                                         <option value="">Selecione</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('medicos') }}</small>
                    </div>

                    <h6>Dados da Data da Consulta</h6>
                    <div class="form-group row">
                        <label for="especializacoes[data]" class="col-md-4 col-form-label text-md-right">Data da Consulta</label>
                        <div class="col-md-6">
                            <input id="nome" type="date" class="form-control" name="data" >
                            <small id="error" class="errors font-text text-danger">{{$errors->first('data')}}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="especializacoes[hora]" class="col-md-4 col-form-label text-md-right">Horas Disponíveis </label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control" name="hora">
                                    <option value="">Selecione</option>
                                        <option value="14:30">14:30</option>
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{$errors->first('hora')}}</small>
                    
                    </div>
                </div>
            </div>
        </div>
        </form>
        </div>
            <div class="card-footer">
                <div class="form-group row mb-0">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-success send-form">
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