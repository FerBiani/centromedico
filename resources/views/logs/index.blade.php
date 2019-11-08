@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">{{ $data['title'] }}</div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <form id="form-pesquisa">
                            <div class="input-group">
                                <input name="pesquisa" placeholder="Pesquisa..." class="form-control" type="text"/>
                            </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-inline">
                            <label class="sr-only" for="acao">Tipo:</label>
                            <select class="form-control" name="acao">
                                <option value="">Todas as ações</option>
                                <option value="Inclusão">Inclusão</option>
                                <option value="Exclusão">Exclusão</option>
                                <option value="Alteração">Alteração</option>
                                <option value="Check-in">Check-in</option>
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn btn-dark"><i class="fas fa-search" style="margin: 5px"></i> Pesquisar</button>
                    </div>
                    </form>
                </div>
                <div class="tab-content" id="myTabContent">
                <div class="table-responsive">
                    <table id="horario-table" class="table table-hover">
                        <thead class="thead thead-light">
                            <tr>
                                <th>Usuário</th>
                                <th>Ação</th>
                                <th>Descrição</th>
                                <th>Data</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['logs'] as $log)
                                <tr>
                                    <td>{{\App\Usuario::find($log->usuario_id)->nome}}</td>
                                    <td><span class="badge badge-{{ $log->getCor() }}">{{$log->acao}}</span></td> 
                                    <td>{{$log->descricao}}</td>
                                    <td>{{ date( "d/m/Y", strtotime($log->created_at)) }}</td>
                                    <td>{{ date( "H:i:s", strtotime($log->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="100%" class="text-center">
                                <p class="text-center">
                                    Página {{$data['logs']->currentPage()}} de {{$data['logs']->lastPage()}}
                                    - Exibindo {{$data['logs']->perPage()}} registro(s) por página de {{$data['logs']->total()}}
                                    registro(s) no total
                                </p>
                                </td>     
                            </tr>
                            @if($data['logs']->lastPage() > 1)
                            <tr>
                                <td colspan="100%">
                                {{ $data['logs']->links() }}
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
                url: "{{url('logs/list')}}",
                data: form.serialize(), 
                success: function(data)
                {
                    $("#myTabContent").html(data)
                }
            });

        });
</script>
@endsection