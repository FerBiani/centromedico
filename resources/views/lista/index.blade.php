@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Lista de Consultas</div>
            <div class="card-body">  
            @if(Auth::user()->nivel_id == 4)
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
                </div>
            @endif
            <div class="tab-content" id="myTabContent">
                <div class="table-responsive">
                    <table id="lista-table" class="table table-hover">
                        <thead class="thead thead-light">
                            <tr>
                                <th>Nome</th>
                                <th>Hora</th>
                                <th>Fim</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultas as $consulta)
                                <tr>
                                    <td>{{\App\Usuario::find($consulta->paciente_id)->nome}}</td>
                                    <td>{{ date('H:i', strtotime($consulta->getOriginal('inicio'))) }}</td>
                                    <td>{{ date('H:i', strtotime($consulta->getOriginal('fim'))) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="100%" class="text-center">
                            <p class="text-center">
                                Página {{$consultas->currentPage()}} de {{$consultas->lastPage()}}
                                - Exibindo {{$consultas->perPage()}} registro(s) por página de {{$consultas->total()}}
                                registro(s) no total
                            </p>
                            </td>     
                        </tr>
                        @if($consultas->lastPage() > 1)
                        <tr>
                            <td colspan="100%">
                            {{ $consultas->links() }}
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
                url: "{{url('lista/medicos')}}",
                data: form.serialize(), 
                success: function(data)
                {
                    $("#myTabContent").html(data)
                    console.log(data)
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