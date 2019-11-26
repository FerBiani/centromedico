@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Lista de Espera de Consultas</div>
            <div class="card-body">  
            <div class="row mb-4">
                <div class="col-md-6">
                    <form id="form-pesquisa">
                        <div class="input-group">
                            <input name="pesquisa" placeholder="Pesquisa..." class="form-control" type="text"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-dark"><i class="fas fa-search" style="margin: 5px"></i> Pesquisar</button>
                    </div>
                    </form>
                    <div class="col-md-3">
                        <a href="{{url('lista/create')}}"><button class="btn btn-success">Adicionar Paciente</button></a>
                    </div>
                </div>
            <div class="tab-content" id="myTabContent">
                <div class="table-responsive">
                    <table id="lista-table" class="table table-hover">
                        <thead class="thead thead-light">
                            <tr>
                                <th>Nome</th>
                                <th>Dia Semana</th>
                                <th>Especialização</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['dados'] as $dado)
                                <tr>
                                    <td>{{\App\Usuario::find($dado->paciente_id)->nome}}</td>
                                    <td>{{\App\DiaSemana::find($dado->dia_semana_id)->dia}}</td>
                                    <td>{{ \App\Especializacao::find($dado->especializacao_id)->especializacao }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="100%" class="text-center">
                            <p class="text-center">
                                Página {{$data['dados']->currentPage()}} de {{$data['dados']->lastPage()}}
                                - Exibindo {{$data['dados']->perPage()}} registro(s) por página de {{$data['dados']->total()}}
                                registro(s) no total
                            </p>
                            </td>     
                        </tr>
                        @if($data['dados']->lastPage() > 1)
                        <tr>
                            <td colspan="100%">
                            {{ $data['dados']->links() }}
                            </td>
                        </tr>
                        @endif
                    </tfoot>
                    </table>
                 </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

@section('js')
<script>
        $("#form-pesquisa").submit(function(e) {
        e.preventDefault();
        var form = $(this);       
            $.ajax({
                type: "GET",
                url: "{{url('lista/list')}}",
                data: form.serialize(), 
                success: function(data)
                {
                    $("#myTabContent").html(data)
                },
                error: function(){
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Nenhum resultado foi encontrado'
                    })
                }

            });

        });
</script>
@endsection