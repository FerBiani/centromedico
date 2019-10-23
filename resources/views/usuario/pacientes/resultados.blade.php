<div class="table-responsive">
    <table id="usuario-table" class="table table-hover">
        <thead class="thead thead-dark">
            <tr>
                <th>Nome</th>
                <th>Dia</th>
                <th>Data</th>
                <th>Inicio</th>
                <th>Fim</th>
                <th colspan="4" class="min">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                @foreach($usuario->horarios as $horario)
                    <tr>
                        <td>{{$usuario->nome}}</td> 
                        <td>{{\App\DiaSemana::find($horario->dias_semana_id)->dia}}</td>
                        <td>{{ date('d/m/Y') }}</td>
                        <td>{{$horario->inicio}}</td>
                        <td>{{$horario->fim}}</td>
                        <td class="min">
                            <a href="{{ url('atendente/confirma/'.$horario->id.'/'.$usuario->id) }}"><button class="btn btn-primary">Agendar</button></a> 
                            <!-- <form action="{{url('usuario', [$usuario->id])}}" class="input-group" method="POST">
                                {{method_field('DELETE')}}
                                {{ csrf_field() }}
                                <input type="submit" class="btn btn-primary" value="Agendar"/>
                            </form> -->
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="100%" class="text-center">
                <p class="text-center">
                    Página {{$usuarios->currentPage()}} de {{$usuarios->lastPage()}}
                    - Exibindo {{$usuarios->perPage()}} registro(s) por página de {{$usuarios->total()}}
                    registro(s) no total
                </p>
                </td>     
            </tr>
            @if($usuarios->lastPage() > 1)
            <tr>
                <td colspan="100%">
                {{ $usuarios->links() }}
                </td>
            </tr>
            @endif
        </tfoot>
    </table>
</div>