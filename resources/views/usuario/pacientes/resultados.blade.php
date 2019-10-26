<div class="table-responsive">
    <table id="usuario-table" class="table table-hover">
        <thead class="thead thead-dark">
            <tr>
                <th>Médico</th>
                <th>Dia</th>
                <th>Inicio</th>
                <th>Fim</th>
                <th colspan="4" class="min">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios as $horario)
            
                <tr>
                    <td>{{$horario->usuario->nome}}</td> 
                    <td>{{$horario->dia->dia}}</td>
                    <td>{{$horario->inicio}}</td>
                    <td>{{$horario->fim}}</td>
                    <td class="min">
                        <a href="{{ url('atendente/confirma/'.$horario->id) }}"><button class="btn btn-primary">Agendar</button></a> 
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