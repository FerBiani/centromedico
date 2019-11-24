@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">
                Consultas Agendadas
            </div>
            <div class="card-body">
                @foreach($data['consultas'] as $consulta)
                <div class="alert alert-secondary" role="alert">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h6 class="alert-heading"><i class="fas fa-hashtag"></i> {{ $consulta->id }} </h6>
                        </div>
                        <div class="col-md-3">
                        @if($consulta->agendamento_id)                       
                            <h6 class="alert-heading"><i class="fas fa-back"></i> Retorno da consulta <i class="fas fa-hashtag"></i> {{ $consulta->agendamento_id }} </h6>                      
                        @endif
                        </div>
                        <div id="botoes-superiores-{{$consulta->id}}" class="col-md-6 text-right">
                            @if($consulta->check_in_id && $consulta->status_id == 1)
                                <button class="btn btn-warning text-white" onClick="chamarPaciente({{$consulta->id}}, '{{$consulta->paciente->nome}}', '{{$consulta->especializacao->especializacao}}', '{{$consulta->inicio}}')">Chamar paciente</button>
                            @endif
                            @if($consulta->status_id == 1)
                                <button class="btn btn-info" onClick="status({{$consulta->id}})">Status da Consulta</button>
                            @else
                                <button class="btn btn-secondary disabled" onClick="statusDisable()">Status da Consulta</button>
                            @endif
                            <a target="blank" class="btn btn-dark" href="{{url('atestados/gerar/'.$consulta->paciente_id)}}">Gerar Atestado</a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h6 class="alert-heading"><i class="far fa-calendar-alt"></i> {{ $consulta->inicio }} </h6>
                        </div>
                        <div class="col-md-3">
                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> {{ $consulta->status_id ? $consulta->status->nome : ''   }} </h6>
                        </div>
                        <div class="col-md-3">
                            <h6 class="alert-heading"><i class="fas fa-receipt"></i> {{ $consulta->codigo_check_in }} </h6>
                        </div>
                    </div>
                    <hr>
                    <div class="row">    
                        <div class="col-md-3"><p><i class="fas fa-user"></i> {{ $consulta->paciente->nome }}</p></div>
                        <div class="col-md-3"><p><i class="fas fa-stethoscope"></i> {{ \App\Especializacao::find($consulta->especializacao_id)->especializacao }}</p></div>
                        <div class="col-md-3">
                            <p id="checkin-status-{{$consulta->id}}" class="{{$consulta->check_in_id ? 'text-success' : 'text-danger'}}">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span class="checkin-status-text">
                                    {{$consulta->check_in_id ? 'Check-in efetuado' : 'Check-in não efetuado'}}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <a href=""></a>
                @endforeach
                <p class="text-center">
                    Página {{$data['consultas']->currentPage()}} de {{$data['consultas']->lastPage()}}
                    - Exibindo {{$data['consultas']->perPage()}} registro(s) por página de {{$data['consultas']->total()}}
                    registro(s) no total
              </p>
                <div class="col-md-12 text-center">
                    @if($data['consultas']->lastPage() > 1)
                        {{ $data['consultas']->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>

    socket.on('check_in', function(data){
        console.log(data)

        $("#checkin-status-"+data.agendamento_id)
            .removeClass('text-danger')
            .addClass('text-success')
            .find('.checkin-status-text')
            .text('Check-in efetuado')

        $("#botoes-superiores-"+data.agendamento_id).prepend(
            '<button class="btn btn-warning text-white" onClick="chamarPaciente('+data.agendamento_id+','+data.nome_paciente+','+data.especializacao_id+')">Chamar paciente</button>'
        )
    })

    //chama proximo paciente
    function chamarPaciente(consultaId, nomePaciente, especializacao, horario) {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            type: "POST",
            url: "http://localhost:8888/chamado",
            data: {
                'id': consultaId,
                'nome_paciente': nomePaciente,
                'especialidade': especializacao,
                'horario': horario
            }, 
            success: function(data)
            {
                Swal.fire('Paciente chamado com sucesso!')
            },
            error: function(err) {
                console.log(err)
            }
        });
    } 

    function statusDisable(){
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Você não pode mais alterar o status desta consulta!',
        })
    }

    //seta o status da consulta
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
                success: function(data)
                {

                    Swal.fire(data.message)

                    //atualiza a página
                    setTimeout(() => {
                        location.reload()
                    }, 1000);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(thrownError);

                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Você não pode mais alterar o status desta consulta!',
                    })
                }
            });
        }
    })
    }
</script>
@stop