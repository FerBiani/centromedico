@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Consultas Agendadas
            </div>
            <div class="card-body">
<<<<<<< HEAD
                @foreach($data['consultas'] as $consulta)
                <div class="alert alert-secondary" role="alert">
                    <div class="row align-items-center">
                        <div class="col-md-3"><h6 class="alert-heading"><i class="far fa-calendar-alt"></i> {{ $consulta->inicio }} </h6></div>
                        <div class="col-md-3"><h6 class="alert-heading"><i class="fas fa-info-circle"></i> {{ $consulta->status_id ? $consulta->status->nome : ''   }} </h6></div>
                        <div class="col-md-3"><a href="{{'atendente/atestado/'.$consulta->id}}" target="_blank"><button class="btn btn-warning text-white">Atestado de Horário</button></a></div>
                        <div class="col-md-3 text-right">
                            <button class="btn btn-info consulta" onClick="status({{$consulta->id}})">Status da Consulta</button>
=======
                @if(!count($data['consultas']))
                    <p class="text-center">Nenhuma consulta cadastrada.</p>
                @else
                    @foreach($data['consultas'] as $consulta)
                    <div class="alert alert-secondary" role="alert">
                        
                        <div class="row align-items-center">
                            <div class="col-md-3"><h6 class="alert-heading"><i class="far fa-calendar-alt"></i> {{ $consulta->inicio }} </h6></div>
                            <div class="col-md-3"><h6 class="alert-heading"><i class="fas fa-info-circle"></i> {{ $consulta->status_id ? $consulta->status->nome : ''   }} </h6></div>
                            <div class="col-md-3"><h6 class="alert-heading"><i class="fas fa-receipt"></i> {{ $consulta->codigo_check_in }} </h6></div>
                            <div class="col-md-3 text-right">
                                <button class="btn btn-info" onClick="status({{$consulta->id}})">Status da Consulta</button>
                            </div>
>>>>>>> 50fdabb60883cb972038565d2a7cbbd26e29a7f2
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col-md-3"><p><i class="fas fa-user"></i> {{ \App\Usuario::find($consulta->medico_id)->nome }}</p></div>
                            <div class="col-md-3"><p><i class="fas fa-stethoscope"></i> {{ \App\Especializacao::find($consulta->especializacao_id)->especializacao }}</p></div>
                            <div class="col-md-3">
                                <p id="checkin-status-{{$consulta->id}}" class="{{$consulta->check_in_id ? 'text-success' : 'text-danger'}}">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="checkin-status-text">
                                        {{$consulta->check_in_id ? 'Check-in efetuado' : 'Check-in não efetuado'}}
                                    </span>
                                </p>
                            </div>
                            @if(!$consulta->check_in_id)
                            <div class="col-md-3 text-right" id="btn-efetuar-checkin-{{$consulta->id}}">
                                <form method="POST" action="{{url('check-in')}}">
                                    @csrf
                                    <input type="hidden" name="agendamento_id" value="{{$consulta->id}}">
                                    <button class="btn btn-success">Efetuar Check-in</button>
                                </form>
                            </div>
                            @endif
                        </div>
                        @if($consulta->status_id == 4)
                        <div class="col-md-3 text-right" id="btn-efetuar-checkin-{{$consulta->id}}">
                            <a href="{{url('retorno/create/'.$consulta->id)}}"><button class="btn btn-primary">Agendar Retorno</button></a>
                        </div>
                        @endif
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

        $("#btn-efetuar-checkin-"+data.agendamento_id).remove()
    })

    function status(id){
<<<<<<< HEAD
        $( ".consulta" ).click(function() {
            const { value } = Swal.fire({
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
            var form = $(this); 
            console.log(value)
=======
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
>>>>>>> 50fdabb60883cb972038565d2a7cbbd26e29a7f2
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
                   
                }
            });
        }
            
        })
    }
</script>
@stop