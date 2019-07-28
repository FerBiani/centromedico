@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">

                <div class="row">

                    @if(Auth::user()->nivel_id <= 2)

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">Usuários</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('usuario')}}"><i class="fas fa-6x fa-users"></i></a>
                                </div>
                            </div>
                        </div>
                    @elseif(Auth::user()->nivel_id == 4)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">Ficha</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('#')}}"><i class="fas fa-6x fa-clipboard-list"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">Meus Agendamentos</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('#')}}"><i class="fas fa-6x fa-calendar-check"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">Agendar Consulta</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('pacientes/agendamento')}}"><i class="fas fa-6x fa-clock"></i></a>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
