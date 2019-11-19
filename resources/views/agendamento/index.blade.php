@extends('layouts.app') @section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Consultas Agendadas
            </div>
            <div class="card-body">
                @if(!count($data['consultas']))
                <p class="text-center">Nenhuma consulta cadastrada.</p>
                @else @foreach($data['consultas'] as $consulta)
                <div class="alert alert-secondary" role="alert">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h6 class="alert-heading"><i class="far fa-calendar-alt"></i> {{ $consulta->inicio }} </h6></div>
                        <div class="col-md-3">
                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> {{ $consulta->status_id ? $consulta->status->nome : ''   }} </h6></div>
                       
                        <div class="col-md-6 text-right">
                            @if($consulta->status_id == 4)
                                <button onClick="abrirModalRetorno('{{$consulta}}')" class="btn btn-primary">Agendar Retorno</button>
                            @endif
                            <a href="{{'atendente/atestado/'.$consulta->id}}" target="_blank">
                                <button class="btn btn-warning text-white">Atestado de Horário</button>
                            </a>
                            <button class="btn btn-info" onClick="status({{$consulta->id}})">Status da Consulta</button>
                        </div>

                    </div>
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <p><i class="fas fa-user"></i> {{ \App\Usuario::find($consulta->medico_id)->nome }}</p>
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
            <div class="form-group">
                <label for="select-dias-semana">Dia da semana</label>
                <input id="medico_id" type="hidden" name="medico_id">
                <input id="especializacao_id" type="hidden" name="especializacao_id">
                <input id="agendamento_id" type="hidden" name="agendamento_id">
                <select id="select-dias-semana" class="form-control">
                    <option value="1">Segunda-feira</option>
                    <option value="2">Terça-feira</option>
                    <option value="3">Quarta-feira</option>
                    <option value="4">Quinta-feira</option>
                    <option value="5">Sexta-feira</option>
                    <option value="6">Sábado</option>
                    <option value="7">Domingo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="select-dias-semana">Horário desejado</label>
                <input id="horario" class="form-control" type="text" name="horario">
            </div>
            <div class="form-group text-center">
                <button id="btn-buscar-horarios" onclick="buscarHorarios()" class="btn btn-primary">Buscar horários</button>
            </div>
            <div class="form-group">
                <label for="select-dias-mes">Dia do mês</label>
                <select id="select-dias-mes" class="form-control"></select>
            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha256-bQmrZe4yPnQrLTY+1gYylfNMBuGfnT/HKsCGX+9Xuqo=" crossorigin="anonymous"></script>
@section('js')
<script>

    socket.on('check_in', function(data){

        $("#checkin-status-"+data.agendamento_id)
            .removeClass('text-danger')
            .addClass('text-success')
            .find('.checkin-status-text')
            .text('Check-in efetuado')

        $("#btn-efetuar-checkin-"+data.agendamento_id).remove()
    })

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
                   
                }
            });
        }   
        })
    }

    function abrirModalRetorno(consulta){

        consulta = JSON.parse(consulta)

        $('#medico_id').val(consulta['medico_id'])
        $('#especializacao_id').val(consulta['especializacao_id'])
        $('#agendamento_id').val(consulta['id'])

        $('#retornoModal').modal('show')
       
    }

    function buscarHorarios() {

        let agendamento_id = $('#agendamento_id').val()
        let dia_semana_id = $('#select-dias-semana').find('option:selected').val()
        let horario = $('#horario').val()

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
                    diasMes.push('<option value="'+dia+'">'+dia+'</option>')
                })

                $('#select-dias-mes').append(diasMes)

                $("#btn-buscar-horarios").text('Buscar horários')
                
            },
            error: function() {
                $("#btn-buscar-horarios").text('Buscar horários')
            }
            
        });

    }

    
</script>
@stop