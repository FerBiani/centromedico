@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Usuários</div>
                            <div class="card-body text-center">
                                <a class="btn" href="{{url('usuario')}}"><i class="fas fa-6x fa-users"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Consultas</div>
                            <div class="card-body text-center">
                                <a class="btn" href="#"><i class="fas fa-6x fa-calendar-alt"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
