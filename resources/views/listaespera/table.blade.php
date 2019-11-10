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
            @foreach($dados as $dado)
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
                Página {{$dados->currentPage()}} de {{$dados->lastPage()}}
                - Exibindo {{$dados->perPage()}} registro(s) por página de {{$dados->total()}}
                registro(s) no total
            </p>
            </td>     
        </tr>
        @if($dados->lastPage() > 1)
        <tr>
            <td colspan="100%">
            {{ $dados->links() }}
            </td>
        </tr>
        @endif
    </tfoot>
    </table>
</div>