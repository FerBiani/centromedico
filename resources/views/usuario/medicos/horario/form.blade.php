@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header bg-info text-white h5">{{$data['title']}}</div>
        <div class="card-body">
            <form id="form" method="POST" action="{{url($data['url'])}}">
                @csrf
                @if($data['method'])
                    @method($data['method'])
                @endif
                <div class="row">
                    @if(!$data['horario'])
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="dia-semana">Tipo de horário</label>
                                <select class="form-control" id="duracao" name="horario[tipo]">
                                    <option value="1">Apenas um horário</option>
                                    <option value="2">Diversos horários</option>
                                </select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('horario.tipo') }}</small>
                            </div>
                        </div>
                        <div class="col-md-12" id="tipo">
                            <div class="form-group">
                                <label for="dia-semana">Duração da consulta</label>
                                <input class="form-control duracao" name="horario[duracao]">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('horario.duracao') }}</small>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dia-semana">Especialização do atendimento</label>
                            <select class="form-control especializacao_id" id="especializacao_id" name="horario[especializacao_id]">
                            @foreach($data['especializacoes'] as $especializacao)
                                <option {{$data['horario'] && $data['horario']->especializacao_id == $especializacao->id ? 'selected' : ''}} value="{{$especializacao->id}}" >{{$especializacao->especializacao}}</option>
                            @endforeach
                            </select> 
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('') }}</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dia-semana">Dia da semana</label>
                            <select class="form-control dia_semana" id="dia-semana" name="horario[dia_semana]">
                            @foreach($data['dias'] as $dia)
                                <option {{$data['horario'] && $data['horario']->dias_semana_id == $dia->id ? 'selected' : ''}} value="{{$dia->id}}">{{$dia->dia}}</option>
                            @endforeach
                            </select> 
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('') }}</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inicio">Início </label>
                            <input type="text" value="{{old('horario.inicio', $data['horario'] ? $data['horario']->inicio : '')}}" class="form-control inicio" id="inicio" name="horario[inicio]">
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('horario.inicio') }}</small>
                        </div>    
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fim">Fim</label>
                            <input type="text" value="{{old('horario.fim', $data['horario'] ? $data['horario']->fim : '')}}" class="form-control fim" id="fim" name="horario[fim]">                        
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('horario.fim') }}</small>
                        </div>
                    </div>
                </div>          
            </form>
        </div>
        <div class="card-footer bg-info">
            <div class="form-group row mb-0">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-dark send-form">
                        Enviar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(document).on('click', '.send-form', function() {
            if($("#form").valid()){
                $(".send-form").prop("disabled",true) 
                $("#form").submit()
            }
        })
        
        $(document).ready(function() {
            $('#tipo').hide();
            $('#duracao').change(function() {
                if ($('#duracao').val() == '2') {
                $('#tipo').show();
                } else {
                $('#tipo').hide();
                }
            });
        });

        //MÁSCARAS
        $('.inicio').mask('00:00')
        $('.fim').mask('00:00')


        ///// VALIDATE /////
        $.validator.addMethod("time24", function(value, element) {
            if (!/^\d{2}:\d{2}$/.test(value)) return false;
            var parts = value.split(':');
            if (parts[0] > 23 || parts[1] > 59 || parts[2] > 59) return false;
            return true;
        }, "Horário inválido");

        $("#form").validate({
            highlight:function(input){
                jQuery(input).addClass('is-invalid');
            },

            unhighlight:function(input){
                jQuery(input).removeClass('is-invalid');
                jQuery(input).addClass('is-valid');
            },

            errorPlacement:function(error, element)
            {
                jQuery(element).parents('.form-group').find('#error').append(error);
            },

            rules: {
                "horario[dia_semana]": "required",
                "horario[tipo]": "required",
                "horario[especializacao_id]":"required",
                "horario[duracao]": "required",
                "horario[inicio]": {
                    required:true,
                    time24: true
                },
                "horario[fim]": {
                    required: true,
                    time24: true
                }
            },

            messages: {

                "horario[dia_semana]":{
                    required: 'Este campo é obrigatório',
                },
                "horario[tipo]":{
                    required: 'Este campo é obrigatório',
                },
                "horario[especializacao_id]":{
                    required: 'Este campo é obrigatório',
                },
                "horario[duracao]":{
                    required: 'Este campo é obrigatório',
                },
                "horario[inicio]":{
                    required: 'Este campo é obrigatório',
                },
                "horario[fim]":{
                    required: 'Este campo é obrigatório',
                },

            },
        });
    </script>
@stop