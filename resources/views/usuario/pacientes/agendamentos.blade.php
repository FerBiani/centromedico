@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>
            <div class="card-body">
            	@foreach($data['consultas'] as $consulta)
                <div class="alert alert-secondary" role="alert">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-danger" onClick="status({{$consulta->id}})">Cancelar</button>
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