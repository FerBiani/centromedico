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
                        <label for="periodo[dia_semana]" class="col-md-4 col-form-label text-md-right">Dias da semana</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control dia_semana" name="dia_semana">
                                        <option value="1">Segunda-feira</option>
                                        <option value="2">Terça-feira</option>
                                        <option value="3">Quarta-feira</option>
                                        <option value="4">Quinta-feira</option>
                                        <option value="5">Sexta-feira</option>
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('') }}</small>
                    </div>
                    <div class="form-group row">
                        <label for="periodo[inicio]" class="col-md-4 col-form-label text-md-right">Início do período</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control especialidade" name="inicio">
                                        <option value="08:00:00">8:00</option>
                                        <option value="13:00:00">13:00</option>
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacoes.nome') }}</small>
                    </div>    
                    <div class="form-group row">
                        <label for="periodo[fim]" class="col-md-4 col-form-label text-md-right">Fim do período</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control especialidade" name="fim">
                                        <option value="12:00:00">12:00</option>
                                        <option value="18:00:00">18:00</option>
                                </select>
                            </div>
                        </div>
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacoes.nome') }}</small>
                    </div>  
                    <input type="hidden" name="usuarios_id" value="{{ auth::user()->id }}">         
                </form>
            </div>
            <div class="card-footer">
                <div class="form-group row mb-0">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success send-form">
                            Enviar
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