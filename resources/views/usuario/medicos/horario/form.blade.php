@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header">{{$data['title']}}</div>
        <div class="card-body">
            <form id="form" method="POST" action="{{url($data['url'])}}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dia-semana">Dia da semana</label>
                            <select class="form-control dia_semana" id="dia-semana" name="horario[dia_semana]">
                                <option value="1">Segunda-feira</option>
                                <option value="2">Terça-feira</option>
                                <option value="3">Quarta-feira</option>
                                <option value="4">Quinta-feira</option>
                                <option value="5">Sexta-feira</option>
                                <option value="6">Sábado</option>
                                <option value="7">Domingo</option>
                            </select> 
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('') }}</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inicio">Início</label>
                            <select class="form-control especialidade" id="inicio" name="horario[inicio]">
                                <option value="07:00:00">7:00</option>
                                <option value="08:00:00">8:00</option>
                                <option value="09:00:00">9:00</option>
                                <option value="10:00:00">10:00</option>
                                <option value="11:00:00">11:00</option>
                                <option value="12:00:00">12:00</option>
                                <option value="13:00:00">13:00</option>
                                <option value="14:00:00">14:00</option>
                                <option value="15:00:00">15:00</option>
                                <option value="16:00:00">16:00</option>
                                <option value="17:00:00">17:00</option>
                                <option value="18:00:00">18:00</option>
                            </select>
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacoes.nome') }}</small>
                        </div>    
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            
                            <label for="fim">Fim</label>
                            <select class="form-control especialidade" id="fim" name="horario[fim]">
                                <option value="07:00:00">7:00</option>
                                <option value="08:00:00">8:00</option>
                                <option value="09:00:00">9:00</option>
                                <option value="10:00:00">10:00</option>
                                <option value="11:00:00">11:00</option>
                                <option value="12:00:00">12:00</option>
                                <option value="13:00:00">13:00</option>
                                <option value="14:00:00">14:00</option>
                                <option value="15:00:00">15:00</option>
                                <option value="16:00:00">16:00</option>
                                <option value="17:00:00">17:00</option>
                                <option value="18:00:00">18:00</option>
                            </select>
                        
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacoes.nome') }}</small>
                        </div>
                    </div>
                </div>          
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
@endsection
@section('js')
    <script type="text/javascript" src="{{ asset('js/mainForm.js') }}"></script>
@stop