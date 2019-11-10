@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Lista de Espera de Consultas</div>
            <div class="card-body">  
            <form id="form" method="POST" action="{{url($data['url'])}}">
                @csrf
                @if($data['method'])
                    @method($data['method'])
                @endif
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="" class="col-form-label">Paciente</label>
                            <div class="input-group">
                                <select id="paciente-select" class="form-control " name="paciente_id"></select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('lista.paciente') }}</small>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="col-form-label">Dia da Semana</label>
                            <div class="input-group">
                                <select id="dia-select" class="form-control" name="dia_semana_id">
                                @foreach($data['dias'] as $dia)
                                    <option value="{{$dia->id}}">{{$dia->dia}}</option>
                                @endforeach
                                </select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('lista.dia') }}</small>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="col-form-label">Especialização</label>
                            <div class="input-group">
                                <select id="especializacao-select" class="form-control" name="especializacao_id">
                                @foreach($data['especializacoes'] as $especializacao)
                                    <option value="{{$especializacao->id}}">{{$especializacao->especializacao}}</option>
                                @endforeach
                                </select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('lista.especializacao') }}</small>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js') 
<script type="text/javascript">
   
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
