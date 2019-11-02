<div class="table-responsive">
    <table id="horario-table" class="table table-hover">
        <thead class="thead thead-dark">
            <tr>
                <th>Usuário</th>
                <th>Ação</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{\App\Usuario::find($log->usuario_id)->nome}}</td>
                    <td>{{$log->acao}}</td> 
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
                    Página {{$logs->currentPage()}} de {{$logs->lastPage()}}
                    - Exibindo {{$logs->perPage()}} registro(s) por página de {{$logs->total()}}
                    registro(s) no total
                </p>
                </td>     
            </tr>
            @if($logs->lastPage() > 1)
            <tr>
                <td colspan="100%">
                {{ $logs->links() }}
                </td>
            </tr>
            @endif
        </tfoot>
    </table>
</div>