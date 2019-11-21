@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>
            <div class="card-body">
            	@foreach($data['consultas'] as $consulta)
                <div class="alert alert-secondary" role="alert">
                    <div class="row align-items-center">
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
                    <div class="col-md-12 text-right">
                    @if($consulta->status_id != 2)
                        <button class="btn btn-danger"  onClick="status({{$consulta->id}})">Cancelar</button>
                    @else
                    <button class="btn btn-danger disabled">Cancelar</button>
                    @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6"><h6 class="alert-heading"><i class="far fa-calendar-alt"></i> {{ $consulta->inicio }} </h6></div>
                        <div class="col-md-6"><h6 class="alert-heading"><i class="fas fa-receipt"></i> {{ $consulta->codigo_check_in }} </h6></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6"><p><i class="fas fa-user-md"></i> {{ \App\Usuario::find($consulta->medico_id)->nome }}</p></div>
                        <div class="col-md-6"><p><i class="fas fa-stethoscope"></i> {{ \App\Especializacao::find($consulta->especializacao_id)->especializacao }}</p></div>
                    </div>
                </div>
                @endforeach
            </div> 
            <div class="card-footer">
                <p class="text-center">
                    Página {{$data['consultas']->currentPage()}} de {{$data['consultas']->lastPage()}}
                    - Exibindo {{$data['consultas']->perPage()}} registro(s) por página de {{$data['consultas']->total()}}
                    registro(s) no total
                </p>   
                @if($data['consultas']->lastPage() > 1)
                    {{ $data['consultas']->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha256-bQmrZe4yPnQrLTY+1gYylfNMBuGfnT/HKsCGX+9Xuqo=" crossorigin="anonymous"></script>
@section('js')
<script>
    function status(id){
        Swal.fire({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
        })

        Swal.fire({
        title: 'Tem certeza que deseja cancelar esta consulta?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, cancelar!',
        cancelButtonText: 'Não, cancelar!',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#28a745',
        reverseButtons: true
        }).then((result) => {
            if (result.value) { 
                  $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },  
                        type: "POST",
                        url: "{{url('set-status')}}/"+id,
                        data: { 'status_id': 2 },
                        success: function(data){
                            Swal.fire(data.message)

                            //atualiza a página
                            setTimeout(() => {
                                location.reload()
                            }, 1000);
                        },
                        error: function(data){
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text:'Voce não pode cancelar esta consulta',
                            })
                        }	
                    });
            } 
        })
    }

</script>
@endsection