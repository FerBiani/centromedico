@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">Horários</div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="text-right">
                            <a class="btn btn-dark" href="{{url('medicos/horario/create')}}">Novo</a>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="myTabContent">
                    
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
        success: function (data) {
            target.html(data)
        },
        error: function (jqXHR, exception) {
            $("#results").html("<div class='alert alert-danger'>Desculpe, ocorreu um erro. <br> Recarregue a página e tente novamente</div>")
        },
    })
}

list = (url) => {
    search(`${url}`, $("#myTabContent"))

    $(document).on('click', 'ul.pagination a', function(e){
        e.preventDefault()
        search($(this).attr('href'), $("#myTabContent"))
    })
}

$(document).ready(function(){
    list(`${main_url}/medicos/horario/list`)
})

</script>
@endsection