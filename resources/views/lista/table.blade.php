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