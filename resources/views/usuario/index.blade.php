@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">Usuários</div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <form id="form-pesquisa">
                            <div class="input-group">
                                <input name="pesquisa" class="form-control" type="text"/>
                                <div class="input-group-append">
                                    <span id="search-button" class="btn btn-outline-secondary"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-inline">
                                    <label class="sr-only" for="nivel">Tipo:</label>
                                    <select class="form-control" name="nivel">
                                        <option value="all">Todos os tipos</option>
                                        @foreach($niveis as $nivel)
                                            <option value="{{$nivel->id}}">{{$nivel->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    <div class="col-md-3 text-right">
                        <a class="btn btn-dark" href="{{url('usuario/create')}}">Novo</a>
                    </div>
                </div>

                <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="ativos-tab" data-toggle="tab" href="#ativos" role="tab" aria-controls="ativos" aria-selected="true">Ativos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="inativos-tab" data-toggle="tab" href="#inativos" role="tab" aria-controls="inativos" aria-selected="false">Inativos</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="ativos" role="tabpanel"></div>
                    <div class="tab-pane fade" id="inativos" role="tabpanel"></div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
function setLoading(target) {
    var loading = $('<h3></h3>').attr({'class': 'text-center'})
    // var img = $('<img />').attr({'src': main_url+"/modules/funcionario/img/load.svg"})
    // img.appendTo(loading)
    target.html(loading)
}
search = (url, target, ) => {
    setLoading(target)
    $.ajax({
        type: "GET",
        url: url,
        data: $("#form-pesquisa").serialize(),
        success: function (data) {
            target.html(data)
        },
        error: function (jqXHR, exception) {
            $("#results").html("<div class='alert alert-danger'>Desculpe, ocorreu um erro. <br> Recarregue a página e tente novamente</div>")
        },
    })
}
ativosInativos = (url) => {
    search(`${url}/ativos`, $("#ativos"))
    search(`${url}/inativos`, $("#inativos"))
    $("#ativos").on('click', 'ul.pagination a', function(e){
        e.preventDefault()
        search($(this).attr('href'), $("#ativos"))
    })
    $("#inativos").on('click', 'ul.pagination a', function(e){
        e.preventDefault()
        search($(this).attr('href'), $("#inativos"))
    })
}
$(document).on("click", "#search-button", function() {
    ativosInativos(`${main_url}/usuario/list`)
})
$(document).ready(function(){
    ativosInativos(`${main_url}/usuario/list`)
    $(document).on('keypress',function(e) {
        if(e.which == 13) {
            e.preventDefault()
            ativosInativos(`${main_url}/usuario/list`)
        }
    });
})
</script>
@endsection