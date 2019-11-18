<div class="table-responsive">
    <table id="horario-table" class="table table-hover">
        <thead class="thead thead-light">
            <tr>
                <th>Médico</th>
                <th>Vizualisar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados as $medico)
            <tr>
                <td>{{$medico->nome}}</td>
                <td>
                    <a href="{{url('atendente/resultado/'.$medico->id)}}" target="_blank">
                        <button class="btn btn-primary">Resumo Diário <span class="badge badge-light ml-3">{{ \App\Agendamento::where('medico_id', $medico->id)->whereDate('inicio', date('Y-m-d'))->count() }}</span></button>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="100%" class="text-center">
                    <p class="text-center">
                        Página {{$dados->currentPage()}} de {{$dados->lastPage()}} - Exibindo {{$dados->perPage()}} registro(s) por página de {{$dados->total()}} registro(s) no total
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