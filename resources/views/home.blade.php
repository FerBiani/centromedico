@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">Dashboard</div>
            <div class="card-body">
                <div class="row">
                    @if(Auth::user()->nivel_id <= 1)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-info text-white">Usuários</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('usuario')}}"><i class="fas fa-6x fa-users"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-info text-white">Relatórios</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('relatorios')}}"><i class="fas fa-6x fa-sticky-note"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-info text-white">Logs</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('logs')}}"><i class="fas fa-6x fa-filter"></i></a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(Auth::user()->nivel_id == 2)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-info text-white">Ficha</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('pacientes/ficha')}}"><i class="fas fa-6x fa-clipboard-list"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-info text-white">Meus Agendamentos</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('pacientes/agendamentos')}}"><i class="fas fa-6x fa-calendar-check"></i></a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(Auth::user()->nivel_id == 3)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-info text-white">Horários</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('medicos/horario')}}"><i class="fas fa-6x fa-business-time"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-info text-white">Meus Agendamentos</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('medicos/agendamentos')}}"><i class="fas fa-6x fa-calendar-check"></i></a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(Auth::user()->nivel_id == 4)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-info text-white">Todos os Agendamentos</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('agendamentos')}}"><i class="fas fa-6x fa-calendar-check"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                            <div class="card-header bg-info text-white">Agendar Consulta</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('atendente/agendamento/create')}}"><i class="fas fa-6x fa-clock"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                  <div class="card-header bg-info text-white">Usuários</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('usuario')}}"><i class="fas fa-6x fa-users"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-info text-white">Lista de Consultas</div>
                                <div class="card-body text-center">
                                    <a class="btn" href="{{url('lista/pacientes')}}"><i class="fas fa-6x fa-list"></i></a>
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