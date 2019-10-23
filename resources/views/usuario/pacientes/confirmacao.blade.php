@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>   
            <div class="card-body">
                <form id="form" method="post" action="">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="" class="col-form-label">Nome do paciente</label>
                            <div class="input-group">
                                <select class="js-example-basic-single" name="paciente_id">
                                   @foreach($data['pacientes'] as $paciente)
                                    <option value="$paciente->id">{{ $paciente->nome }}</option>
                                   @endforeach
                                </select>
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
                                <input type="text" class="form-control" id="validationCustom01" name="especializacao_id" value="{{ $especializacao->especializacao }}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.especializacao') }}</small>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="" class="col-form-label">Código Check-in</label>
                            <div class="input-group">
                                <?php $codigo = Session::getId()?>
                                <input type="text" class="form-control" id="validationCustom01" name="codigo_check_im" value="">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('agendamento.especializacao') }}</small>
                            </div> 
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.11/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.11/js/select2.min.js"></script>

@section('js') 
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
@stop
