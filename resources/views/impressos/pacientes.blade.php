@extends('layouts.app')
@section('content')
    <div class="card mt-5">
        <div class="card-header">Relátorio da programação diaria de pacientes</div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                    <table id="usuario-table" class="table table-hover">
                        <thead class="thead thead-light">
                            <tr>
                                <th>Médico</th>
                                <th>Vizualisar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicos as $medico)
                                <tr>
                                    <td>{{$medico->nome}}</td>
                                    <td><a href="{{url('atendente/resultado/'.$medico->id)}}" target="_blank"><button class="btn btn-primary">Resumo Diário <span class="badge badge-light ml-3">{{ \App\Agendamento::where('medico_id', $medico->id)->whereDate('inicio', date('Y-m-d'))->count() }}</span></button></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>   
                </div>     
            </div>
        </div> 
    </div>
@endsection
@section('js') 
</script>
@stop