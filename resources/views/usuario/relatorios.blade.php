@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">{{ $data['title'] }}</div>
            <div class="card-body">
                <form id="form">
                    <div class="row">
                        <div class="col-md-8">
                        <label for="exampleFormControlSelect1">Consulta</label>
                            <select class="form-control" name="status">
                                @foreach($data['status'] as $status)
                                    <option value="{{$status->id}}">{{$status->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mt-4">
                            <button class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                </form>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading"></h4>
                    <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
                    <hr>
                    <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
   $("#form").submit(function(e) {
        e.preventDefault(); 
        var form = $(this);
        $.ajax({
            type: "GET",
            url: "{{ url('usuario/status') }}",
            data: form.serialize(), 
            success: function(data)
            {
                console.log(data); 
            }
            });
        });
</script>
@stop