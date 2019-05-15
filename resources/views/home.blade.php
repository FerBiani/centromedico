@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="text-right">
                            <a class="btn btn-info" href="{{url('usuario/create')}}">Novo Usuário</a>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">Pacientes</div>
                            <div class="card-body text-center">
                                <a class="btn" href="{{url('usuario/listar/4')}}"><i class="fas fa-6x fa-user-injured"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">Médicos</div>
                            <div class="card-body text-center">
                                <a class="btn" href="{{url('usuario/listar/3')}}"><i class="fas fa-6x fa-user-md"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">Atendentes</div>
                            <div class="card-body text-center">
                                <a class="btn" href="{{url('usuario/listar/2')}}"><i class="fas fa-6x fa-headset"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">Administradores</div>
                            <div class="card-body text-center">
                                <a class="btn" href="{{url('usuario/listar/1')}}"><i class="fas fa-6x fa-users-cog"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
