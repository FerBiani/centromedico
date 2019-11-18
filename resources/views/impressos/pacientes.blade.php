@extends('layouts.app')
@section('content')
<div class="card mt-5">
    <div class="card-header">Relátorio da programação diaria de pacientes</div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <form id="form-pesquisa">
                        <div class="input-group">
                            <input name="pesquisa" placeholder="Pesquisa..." class="form-control" type="text"/>
                        </div>
                </div>
                <div class="">
                    <button class="btn btn-dark"><i class="fas fa-search" style="margin: 5px"></i> Pesquisar</button>
                </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="tab-content" id="myTabContent">
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
                    <tfoot>
                        <tr>
                            <td colspan="100%" class="text-center">
                            <p class="text-center">
                                Página {{$medicos->currentPage()}} de {{$medicos->lastPage()}}
                                - Exibindo {{$medicos->perPage()}} registro(s) por página de {{$medicos->total()}}
                                registro(s) no total
                            </p>
                            </td>     
                        </tr>
                        @if($medicos->lastPage() > 1)
                        <tr>
                            <td colspan="100%">
                            {{ $medicos->links() }}
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
@section('js') 
<script>

    $("#form-pesquisa").submit(function(e) {
    e.preventDefault();
    var form = $(this);       
        $.ajax({
            type: "GET",
            url: "{{url('atendente/relatorio/list')}}",
            data: form.serialize(), 
            success: function(data)
            {
                $("#myTabContent").html(data)
            }
        });

    });

</script>
@stop