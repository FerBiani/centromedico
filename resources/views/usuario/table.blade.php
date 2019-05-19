<div class="table-responsive">
    <table id="usuario-table" class="table table-hover">
        <thead class="thead thead-dark">
            <tr>
                <th>Tipo</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th colspan="4" class="min">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{$usuario->nivel->nome}}</td>
                    <td>{{$usuario->nome}}</td> 
                    <td>{{$usuario->email}}</td>

                    @if($status == "ativos")
                        <td class="min"> 
                            <a class="btn btn-warning" href='{{ url("usuario/$usuario->id/edit") }}'>Editar</a>
                        </td>
                    @endif

                    <td class="min"> 
                        <form action="{{url('usuario', [$usuario->id])}}" class="input-group" method="POST">
                            {{method_field('DELETE')}}
                            {{ csrf_field() }}
                                <input type="submit" class="btn btn-{{$usuario->trashed() ? 'success' : 'danger'}}" value="{{$usuario->trashed() ? 'Restaurar' : 'Deletar'}}"/>
                        </form>
                    </td>
                </tr>
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