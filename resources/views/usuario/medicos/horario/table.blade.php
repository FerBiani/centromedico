<div class="table-responsive">
    <table id="horario-table" class="table table-hover">
        <thead class="thead thead-light">
            <tr>
                <th>Dia da semana</th>
                <th>Início</th>
                <th>Fim</th>
                <th colspan="4" class="min">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios as $horario)
                <tr>
                    <td>{{\App\DiaSemana::find($horario->dias_semana_id)->dia}}</td>
                    <td>{{$horario->inicio}}</td> 
                    <td>{{$horario->fim}}</td>
                    <td class="min"> 
                        <a class="btn btn-warning text-white" href='{{ url("medicos/horario/$horario->id/edit") }}'>Editar</a>
                    </td>
                    <td class="min"> 
                        <form action="{{url('medicos/horario', [$horario->id])}}" class="input-group" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-danger" value="Deletar"/>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="100%" class="text-center">
                <p class="text-center">
                    Página {{$horarios->currentPage()}} de {{$horarios->lastPage()}}
                    - Exibindo {{$horarios->perPage()}} registro(s) por página de {{$horarios->total()}}
                    registro(s) no total
                </p>
                </td>     
            </tr>
            @if($horarios->lastPage() > 1)
            <tr>
                <td colspan="100%">
                {{ $horarios->links() }}
                </td>
            </tr>
            @endif
        </tfoot>
    </table>
</div>