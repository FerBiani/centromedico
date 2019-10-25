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
                        <div class="col-md-12">
                            <label for="" class="col-form-label">Nome do paciente</label>
                            <div class="input-group">
                                <select class="js-example-basic-single form-control pacientes" name="paciente_id"></select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.especializacao') }}</small>
                            </div> 
                        </div>
                    </div>
                      <div class="form-group row">
                        <div class="col-md-6">
                            <label for="agendamento[inicio]" class="col-form-label">Início</label>
                            <div class="input-group">
                                <input type="text" class="form-control especialidade" name="inicio" value="{{ $data['horario']->inicio }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.inicio') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-form-label">Fim</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="validationCustom01" name="fim" value="{{ $data['horario']->fim }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.fim') }}</small>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="agendamento[medico]" class="col-form-label">Medico</label>
                            <div class="input-group">
                                <input type="text" class="form-control especialidade"  value="{{ $data['medico']->nome }}">
                                <input type="hidden"  name="medico_id" value="{{ $data['medico']->id }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.inicio') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="" class="col-form-label">Especialização</label>
                            <div class="input-group">
                                <?php $especializacao = \App\Especializacao::find($data['horario']->especializacao_id); ?>
                                <input type="text" class="form-control" value="{{ $especializacao->especializacao }}">
                                <input type="hidden" class="form-control" id="validationCustom01" name="especializacao_id" value="{{ $especializacao->id }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.especializacao') }}</small>
                            </div> 
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
        $('.js-example-basic-single').select2({
            ajax: {
                url: "{{url('atendente/pacientes')}}",
                type: 'GET',
                success: function(data){
                    $.each(data, function(i, paciente) {
                        $(".pacientes:not(:has(a))").append(`<option value="${paciente.id}">${paciente.nome}</option>`)
                    })
                }
            }   
        });
    });

        
    $(document).on('click', '.send-form', function() {
        if($("#form").valid()){
            $(".send-form").prop("disabled",true) 
            $("#form").submit()
        }
    })
</script>
@stop
