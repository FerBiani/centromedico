@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Consultas Agendadas
            </div>
            <div class="card-body">
                @foreach($data['consultas'] as $consulta)
                <div class="alert alert-secondary" role="alert">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-info" >Status da Consulta</button>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><h6 class="alert-heading"><i class="far fa-calendar-alt"></i> {{ $consulta->inicio }} </h6></div>
                        <div class="col-md-6"><h6 class="alert-heading"><i class="fas fa-receipt"></i> {{ $consulta->codigo_check_in }} </h6></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3"><p><i class="fas fa-user"></i> {{ \App\Usuario::find($consulta->medico_id)->nome }}</p></div>
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
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha256-bQmrZe4yPnQrLTY+1gYylfNMBuGfnT/HKsCGX+9Xuqo=" crossorigin="anonymous"></script>
@section('js')

<script>

    socket.on('check_in', function(data){
        console.log(data)

        $("#checkin-status-"+data.agendamento_id)
            .removeClass('text-danger')
            .addClass('text-success')
            .find('.checkin-status-text')
            .text('Check-in efetuado')
    })

    
</script>
<script>
    $( ".btn" ).click(function() {
        Swal.fire({
            title: "Selecione o status da consulta", 
            html: "<button class='btn btn-danger'>Finalizada</button> <button class='btn btn-warning'>Paciente não compareceu</button> <button class='btn btn-dark'>Próximo Paciente</button> ",             
            confirmButtonText: "Fechar"
        });
    });
</script>

@stop