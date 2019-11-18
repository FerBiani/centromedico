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
                            <label for="agendamento[inicio]" class="col-form-label">Início</label>
                            <div class="input-group">
                                <input readonly id="inicio" type="text" class="form-control especialidade" name="agendamento[inicio]" value="{{ $data['horario']->inicio }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.inicio') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="agendamento[fim]" class="col-form-label">Fim</label>
                            <div class="input-group">
                                <input readonly id="fim" type="text" class="form-control" id="validationCustom01" name="agendamento[fim]" value="{{ $data['horario']->fim }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.fim') }}</small>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="agendamento[medico_id]" class="col-form-label">Medico</label>
                            <div class="input-group">
                                <input readonly type="text" class="form-control especialidade"  value="{{ $data['horario']->usuario->nome }}">
                                <input type="hidden"  name="agendamento[medico_id]" value="{{ $data['horario']->usuario->id }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.inicio') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="agendamento['especializacao_id']" class="col-form-label">Especialização</label>
                            <div class="input-group">
                                <input readonly type="text" class="form-control" value="{{ $data['horario']->especializacoes->especializacao }}">
                                <input type="hidden"  name="agendamento[especializacao_id]" value="{{ $data['horario']->especializacoes->id }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.especializacao') }}</small>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="agendamento['paciente_id']" class="col-form-label">Paciente</label>
                            <div class="input-group">
                                <select id="paciente-select" class="form-control form-lg" name="agendamento[paciente_id]" required></select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('paciente_id') }}</small> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="agendamento['data']" class="col-form-label">Dia</label>
                            <select id="select-data" class="form-control" name="agendamento[data]">
                                @foreach($data['horario']->diasDoMes() as $dia)
                                    <option>{{$dia->format('d/m/Y')}}</option>
                                @endforeach
                            </select>
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.dia') }}</small>
                        </div>
                    </div>
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
            </form>
        </div>
    </div>
</div>
@endsection


@section('js') 
<script type="text/javascript">

    $(document).ready(function() {

        ///// VALIDATE /////
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
        })

    })
   
   $("#paciente-select").select2({
        width: '100%',
        language: {
        inputTooShort: function() {
            return "Insira pelo menos 4 caracteres";
        },
        errorLoading: function() {
            return "Erro ao carregar os resultados";
        },
        loadingMore: function() {
            return "Carregando mais resultados...";
        },
        noResults: function() {
            return "Nenhum resultado encontrado";
        },
        searching: function() {
            return "Procurando...";
        },
        // maximumSelected: function(args) {
        //   // args.maximum is the maximum number of items the user may select
        //   return "Error loading results";
        // }
        },
        ajax: {
        url: main_url+'/atendente/pacientes',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
            q: params.term, // search term
            page: params.page
            };
        },
        processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = data.current_page || 1;

            return {
            results: data.data,
            pagination: {
                more: (params.page * 30) < data.total
            }
            };
        },
        cache: true
        },
        placeholder: 'Procure por um paciente',
        minimumInputLength: 4,
        templateResult: format,
        templateSelection: formatSelection
    });

    function format (data) {
        console.log(data)
        if (data.loading) {
        return data.text;
        }

        var $container = $(
        "<div class='d-flex align-items-center'>" +
            "<div><p class='nome_paciente h6 ml-2 text-dark'></p></div>" +
        "</div>"
        );

        $container.find(".nome_paciente").text(data.nome);

        return $container;
    }

    function formatSelection (repo) {
        return repo.nome || repo.text;
    }
     
    $(document).on('click', '.send-form', function() {
        if($("#form").valid()){
            $(".send-form").prop("disabled",true) 
            $("#form").submit()
        }
    })
</script>
@stop
