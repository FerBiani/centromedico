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
                    <h6>Dados da Consulta</h6>
                    <div class="form-group row esp">
                        <label class="col-md-4 col-form-label text-md-right">Especialização Desejada</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control" id="especializacoes" >
                                    <option value="">Selecione</option>
                                    @foreach($data['especializacoes'] as $especializacao)
                                        <option value="{{$especializacao->id}}">{{$especializacao->especializacao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacoes') }}</small>
                    </div>
                    <div class="form-group row esp">
                        <label class="col-md-4 col-form-label text-md-right">Médico Desejado</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control" id="medicos">
                                    <option value="">Selecione</option>
                                    @foreach($data['usuarios'] as $usuario)
                                        @if($usuario->especializacoes_count > 0)
                                            <option value="{{$usuario->id}}"> {{$usuario->nome}} </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario') }}</small>
                    </div>

                    <h6>Dados da Data da Consulta</h6>
                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right">Data da Consulta</label>
                        <div class="col-md-6">
                            <input id="nome" type="date" class="form-control" name="data" >
                            <small id="error" class="errors font-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row esp">
                        <label class="col-md-4 col-form-label text-md-right">Horas Disponíveis </label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control" name="hora">
                                    <option value="">Selecione</option>
                                        <option value="#">Horarios disponiveis</option>
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger"></small>
                    
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
@endsection