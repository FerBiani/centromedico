@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Consultas Agendadas
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Paciente</th>
                        <th scope="col">Data</th>
                        <th scope="col">Harario</th>
                        <th scope="col">Confirmar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data['consultas'] as $consulta)
                <?php $paciente = App\Usuario::find($consulta->paciente_id) ?> 
                    <tr>
                        <td>{{$paciente->nome}}</td >
                        <td><?php echo date('d/m/Y', strtotime($consulta->inicio));?></td>
                        <td><?php echo date('H:i', strtotime($consulta->inicio));?></td>
                        <td><button class="btn btn-success"><i class="fas fa-check"></i></button></td>
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
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
@stop