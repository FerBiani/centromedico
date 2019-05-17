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
                                    <a class="btn" href="{{url('usuario/listar/4')}}"><i class="fas fa-6x fa-users"></i></a>
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
