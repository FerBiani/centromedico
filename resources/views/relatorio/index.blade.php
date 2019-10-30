@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">{{ $data['title'] }}</div>
            <div class="card-body">
                <h4 class="text-center">Agendamentos</h4>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header bg-info text-white text-center h6">Confirmados</div>
                            <div class="card-body">
                                <p class="text-center h2 my-0">
                                    {{$data['agendamentos']['confirmados']}}
                                </p>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header bg-info text-white text-center h6">Cancelados</div>
                            <div class="card-body">
                                <p class="text-center h2 my-0">
                                    {{$data['agendamentos']['cancelados']}}
                                </p>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header bg-info text-white text-center h6">Não compareceu</div>
                            <div class="card-body">
                                <p class="text-center h2 my-0">
                                    {{$data['agendamentos']['naoCompareceu']}}
                                </p>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header bg-info text-white text-center h6">Finalizados</div>
                            <div class="card-body">
                                <p class="text-center h2 my-0">
                                    {{$data['agendamentos']['finalizados']}}
                                </p>
                            </div> 
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
   $("#form").submit(function(e) {
        e.preventDefault(); 
        var form = $(this);
        $.ajax({
            type: "GET",
            url: "{{ url('usuario/status') }}",
            data: form.serialize(), 
            success: function(data)
            {
                console.log(data); 
            }
            });
        });
</script>
@stop