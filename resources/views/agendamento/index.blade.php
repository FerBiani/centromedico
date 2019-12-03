@extends('layouts.app') @section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">
                Consultas Agendadas
            </div>
            <div class="card-body">
                @if(!count($data['consultas']))
                <p class="text-center">Nenhuma consulta cadastrada.</p>
                @else @foreach($data['consultas'] as $consulta)
                <div class="alert alert-secondary" role="alert">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <p><i class="fas fa-user"></i> {{ \App\Usuario::find($consulta->paciente_id)->nome }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="alert-heading"><i class="fas fa-hashtag"></i> {{ $consulta->id }} </h6>
                        </div>
                        @if($consulta->agendamento_id)
                        <div class="col-md-3">
                            <h6 class="alert-heading"><i class="fas fa-back"></i> Retorno da consulta <i class="fas fa-hashtag"></i> {{ $consulta->agendamento_id }} </h6>
                        </div>
                        @endif
                    </div>
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h6 class="alert-heading"><i class="far fa-calendar-alt"></i> {{ $consulta->inicio }} </h6>
                        </div> 
                        <div class="col-md-3">
                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> {{ $consulta->status_id ? $consulta->status->nome : ''   }} </h6>
                        </div>
                       
                        <div class="col-md-6 text-right">

                            <?php $diasParaRetorno = $consulta->medico->especializacoes()->wherePivot('especializacao_id', $consulta->especializacao_id)->first()->pivot->tempo_retorno; ?>

                            @if($consulta->status_id == 4 && !$consulta->agendamento_id && $diasParaRetorno != 0)            
                                <button onClick="abrirModalRetorno('{{$consulta}}')" class="btn btn-primary">Agendar Retorno</button>
                            @endif
                            @if($consulta->status_id != 4)
                                <button onClick="atestadoDisable()" class="btn btn-secondary disabled">Atestado de Horário</button>
                            @else
                            <a href="{{'atendente/atestado/'.$consulta->id}}" target="_blank">
                                <button class="btn btn-warning text-white">Atestado de Horário</button>
                            </a>
                            @endif
                            @if($consulta->status_id == 1)
                                <button class="btn btn-info" onClick="status({{$consulta->id}})">Status da Consulta</button>
                            @else
                                <button class="btn btn-secondary disabled" onClick="statusDisable()">Status da Consulta</button>
                            @endif
                        </div>

                    </div>
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <p><i class="fas fa-user-md"></i> {{ \App\Usuario::find($consulta->medico_id)->nome }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><i class="fas fa-stethoscope"></i> {{ \App\Especializacao::find($consulta->especializacao_id)->especializacao }}</p>
                        </div>
                        <div class="col-md-3">
                            <p id="checkin-status-{{$consulta->id}}" class="{{$consulta->check_in_id ? 'text-success' : 'text-danger'}}">
                                <i class="fas fa-check-circle"></i>
                                <span class="checkin-status-text">
                                        {{$consulta->check_in_id ? 'Check-in efetuado' : 'Check-in não efetuado'}}
                                    </span>
                            </p>
                        </div>
                        @if(!$consulta->check_in_id && $consulta->status_id == 1)
                        <div class="col-md-3 text-right" id="btn-efetuar-checkin-{{$consulta->id}}">
                            <form method="POST" action="{{url('check-in')}}">
                                @csrf
                                <input type="hidden" name="agendamento_id" value="{{$consulta->id}}">
                                <button class="btn btn-success">Efetuar Check-in</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach @endif
            </div>
            <p class="text-center">
                Página {{$data['consultas']->currentPage()}} de {{$data['consultas']->lastPage()}} - Exibindo {{$data['consultas']->perPage()}} registro(s) por página de {{$data['consultas']->total()}} registro(s) no total
            </p>
            <div class="col-md-12 text-center">
                @if($data['consultas']->lastPage() > 1) {{ $data['consultas']->links() }} @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="retornoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Marcar Retorno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
            <div id="status" class="row d-none">
            </div>
            <form method="POST" id="form" action="{{url('atendente/agendamento')}}">
                @csrf
                <div class="form-group">
                    <input id="medico_id" type="hidden" name="agendamento[medico_id]">
                    <input id="especializacao_id" type="hidden" name="agendamento[especializacao_id]">
                    <input id="agendamento_id" type="hidden" name="agendamento[agendamento_id]">
                    <input id="paciente_id" type="hidden" name="agendamento[paciente_id]">
                    <input id="inicio_id" type="hidden" name="agendamento[inicio]">
                    <input id="fim_id" type="hidden" name="agendamento[fim]">

                    <label for="select-dias-semana">Dia da semana</label>
                    <select id="select-dias-semana" class="form-control dias-semana" required>
                        <option value="1">Segunda-feira</option>
                        <option value="2">Terça-feira</option>
                        <option value="3">Quarta-feira</option>
                        <option value="4">Quinta-feira</option>
                        <option value="5">Sexta-feira</option>
                        <option value="6">Sábado</option>
                        <option value="7">Domingo</option>
                    </select>
                    <small id="error" class="errors font-text text-danger">{{ $errors->first('dias-semana') }}</small>
                </div>
                <div class="form-group">
                    <label for="select-horarios">Horário desejado</label>
                    <input id="horario" class="form-control horarios" type="text" required>
                    <small id="error" class="errors font-text text-danger">{{ $errors->first('horarios') }}</small>
                </div>
                <div class="form-group text-center">
                    <a href="#" id="btn-buscar-horarios" onclick="buscarHorarios()" class="btn btn-primary text-white">Buscar horários</a>
                </div>
                <div class="form-group">
                    <label for="select-dias-mes">Dia do mês</label>
                    <select name="agendamento[data]" id="select-dias-mes" class="form-control" required></select>
                    <small id="error" class="errors font-text text-danger">{{ $errors->first('dias-mes') }}</small>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-success send-form">Marcar</button>
                </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

</div>
@endsection
@section('js')
<script src="{{asset('js/mainForm.js')}}"></script>
<script>
    
    socket.on('check_in', function(data){

        $("#checkin-status-"+data.agendamento_id)
            .removeClass('text-danger')
            .addClass('text-success')
            .find('.checkin-status-text')
            .text('Check-in efetuado')

        $("#btn-efetuar-checkin-"+data.agendamento_id).remove()
    })

    function statusDisable(){
        Swal.fire({
            icon: 'error',
            title: 'Está consulta não pode ser alterada',
            text: 'Você não pode mais alterar o status desta consulta!',
        })
    }

    function atestadoDisable(){
        Swal.fire({
            icon: 'error',
            title: 'Não foi possível gerar o atestado',
            text: 'Você não pode mais gerar o atestado desta consulta!',
        })
    }

    function status(id){
        const { value: fruit } = Swal.fire({
        title: 'Status da Consulta',
        input: 'select',
        inputOptions: {
        <?php foreach($data['status'] as $status) {?>
            {{ $status->id }}: '{{ $status->nome }}',
        <?php } ?>
        },
        inputPlaceholder: 'Selecione o status',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Enviar',
        confirmButtonColor: '#28a745',
        inputValidator: (value) => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{url('set-status')}}/"+id,
                datatype: "json",
                data: { 'status_id': value }, 
                success: function(data){
                    Swal.fire(data.message)
                    //atualiza a página
                    setTimeout(() => {
                        location.reload()
                    }, 1000);
                   
                },
                error: function(){
                    Swal.fire({
                        icon: 'error',
                        title: 'Está consulta não pode ser alterada',
                        text: 'Você não pode alterar o status desta consuta!'
                    })
                }
            });
        }   
        })
    }

    function abrirModalRetorno(consulta){

        consulta = JSON.parse(consulta)

        $('#medico_id').val(consulta['medico_id'])
        $('#paciente_id').val(consulta['paciente_id'])
        $('#especializacao_id').val(consulta['especializacao_id'])
        $('#agendamento_id').val(consulta['id'])

        $('#retornoModal').modal('show')
       
    }

    function buscarHorarios() {

        let agendamento_id = $('#agendamento_id').val()
        let dia_semana_id = $('#select-dias-semana').find('option:selected').val()
        let horario = $('#horario').val()

        if(agendamento_id == '' || dia_semana_id == '' || horario == '') {
            $("#status").hide().removeClass('d-none').html('<div class="alert alert-warning">Não foram informados todos os parâmetros necessários</div>').fadeIn()

            setTimeout(() => {
                $("#status").fadeOut(function(){
                    $(this).addClass('d-none')
                })
            }, 3000);

            return
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: "{{url('horario/get')}}/"+agendamento_id+'/'+dia_semana_id+'/'+horario,
            datatype: "json",
            beforeSend: function() {
                $("#btn-buscar-horarios").html('<img width="50" src="'+main_url+'/img/loading.gif">')
            },
            success: function(data)
            {

                $('#select-dias-mes').empty()

                let diasMes = []

                $.each(data, function(i, dia) {
                    diasMes.push('<option data-inicio="'+dia['inicio']+'" data-fim="'+dia['fim']+'" value="'+dia['diaDoMes']+'">'+dia['diaDoMes']+' ('+dia['inicio']+' - '+dia['fim']+')</option>')
                })

                $('#select-dias-mes').append(diasMes)
                    
                setInicioFim()

                $("#btn-buscar-horarios").text('Buscar horários')
                
            },
            error: function(xhr, status, error) {

                $('#select-dias-mes').empty()

                let err = JSON.parse(xhr.responseText)

                $("#btn-buscar-horarios").text('Buscar horários')
                $("#status").hide().removeClass('d-none').html('<div class="alert alert-warning">'+err.message+'</div>').fadeIn()

                setTimeout(() => {
                    $("#status").fadeOut(function(){
                        $(this).addClass('d-none')
                    })
                }, 3000);
            }
            
        });

    }

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
    });

    // MASCARA HORARIO
    $('.horarios').mask('00:00')

    function setInicioFim() {
        let optionSelected = $("#select-dias-mes").find('option:selected')
        $("#inicio_id").val(optionSelected.data('inicio'))
        $("#fim_id").val(optionSelected.data('fim'))
    }

    $(document).on('change', '#select-dias-mes', function() {
        setInicioFim()
    })

    
</script>
@stop