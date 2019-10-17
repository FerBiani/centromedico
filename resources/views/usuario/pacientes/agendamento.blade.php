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
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="agendamento[nome]" class="col-form-label">Especialização Desejada</label>
                            <div class="input-group">
                                <input type="text" class="form-control especialidade" name="especializacoes_id">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacoes.nome') }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label">Dia</label>
                            <div class="input-group">
                            <input type="date" class="form-control" id="validationCustom01" name="data" required>
                            </div> 
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                        <label for="agendamento[especializacoes_id]" class="col-form-label">Especialização Desejada</label>
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
                        <div class="col-md-6">
                        <label for="agendamento[medico_id]" class="col-form-label">Médico Desejado</label>
                            <div class="input-group">
                                <select class="form-control medicos" name="medico_id">
                                    <option value="">Selecione</option>
                                    @foreach($data['usuarios'] as $usuario)
                                         <option data-medico="{{$usuario->id}}" value="{{ $usuario->id}}">{{$usuario->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('medicos') }}</small>
                    </div>
            </div>
        </div>
        </form>
        </div>
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