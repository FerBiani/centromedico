@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>   
            <div class="card-body">
                <form id="form">
                    @csrf
                    @if($data['method'])
                        @method($data['method'])
                    @endif
                    <div class="form-group row">
                       <div class="col-md-5">
                            <label for="agendamento[especializacoes_id]" class="col-form-label">Especialização</label>
                            <div class="input-group">
                                <select class="form-control especialidade" name="especializacoes_id">
                                    <option value="">Selecione</option>
                                    @foreach($data['especializacoes'] as $especializacao)
                                        <option data-especializacao="{{$especializacao->especializacao}}" value="{{$especializacao->id}}">{{$especializacao->especializacao}}</option>
                                    @endforeach
                                </select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.especializacoes_id') }}</small>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="agendamento[dias_semana_id]" class="col-form-label">Dia da semana</label>
                            <div class="input-group">
                                <select class="form-control especialidade" name="dias_semana_id">
                                    <option value="">Selecione</option>
                                    @foreach($data['dias'] as $dia)
                                        <option value="{{$dia->id}}">{{$dia->dia}}</option>
                                    @endforeach
                                </select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.dias_semana_id') }}</small>
                            </div>
                        </div>
                        <div class="col-md-2" style="margin-top: 35px">
                            <div class="input-group">
                                <button type="submit" id="filtro-button" class="btn btn-success send-form">
                                    {{$data['button']}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="ativos"></div>
            </div> 
        </div>
    </div>
</div>
@endsection
@section('js') 
<script type="text/javascript">

//MEDICO/especializacoes
$('.especialidade').change(function() {
    atualizarMedicos($(".especialidade option:selected").data("especializacao"), $(".especialidade").data('medico'))
    $(".especialidade").data('medico','')
})

function atualizarMedicos(especializacao, selected_id = null) {
    $.ajax({
        url: main_url + "/get-medicos/"+especializacao,
        type: 'GET',
        success: function(data){
            $(".medicos option").remove();
            $(".medicos").append("<option value=''>Selecione</option>")
            $.each(data, function(i, medico) {
                $(".medicos").append(`<option ${selected_id == medico.id ? 'selected' : ''} value=${medico.id}>${medico.nome}</option>`)
            })
        }
    })
}

function selecionarMedico(medico) {
    $(".medicos option").removeAttr('selected')
    $(".medicos option").each(function() {
        if($(this).text() == medico){
            $(this).attr("selected", "selected")
        }
    })
}

function selecionarEspecializacao(especializacao) {
    $(".especialidade option").removeAttr('selected')
    $(".especialidade option").each(function() {
        if($(this).data("especializacao") == especializacao){
            $(this).attr('selected', 'selected')
        }
    })
}
    //search = (url) => {
        // $.ajax({
        //     type: "GET",
        //     url: "{{url('atendente/filtro')}}",
        //     data: $("#form").serialize(),
        //     success: function (data) {
        //         $("div.ativos").html(data)
        //     }
        // })
    //}
 
    // $(document).on("click", "#filtro-button", function() {
    //     search("{{url('atendente/filtro')}}", $("div.ativos"))
    // })
    $("#form").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);       
        $.ajax({
            type: "GET",
            url: "{{url('atendente/filtro')}}",
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                $("div.ativos").html(data) // show response from the php script.
            }
            });

        });
</script>
@stop