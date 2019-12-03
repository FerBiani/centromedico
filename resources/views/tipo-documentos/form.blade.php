@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">{{$data['title']}}</div>

            <div class="card-body">
                <form id="form" method="POST" action="{{url($data['url'])}}" autocomplete="off">
                    @csrf

                    @if($data['method'])
                        @method($data['method'])
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_documentos[tipo]" class="col-form-label">Tipo</label>
                                <input id="tipo" type="text" class="form-control" name="tipo_documentos[tipo]" value="{{old('tipo_documentos.tipo', $data['tipoDocumento'] ? $data['tipoDocumento']->tipo : '')}}" required>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('tipo_documentos.tipo') }}</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_documentos[possui_complemento]" class="col-form-label">Possuí complemento?</label>
                                <select id="possui_complemento" class="form-control" name="tipo_documentos[possui_complemento]" required>
                                    <option value="0" {{$data['tipoDocumento'] && $data['tipoDocumento']->possui_complemento == 0 ? 'selected' : ''}}>Não</option>
                                    <option value="1" {{$data['tipoDocumento'] && $data['tipoDocumento']->possui_complemento == 1 ? 'selected' : ''}}>Sim</option>
                                </select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('tipo_documentos.possui_complemento') }}</small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="form-group row mb-0">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-success send-form">
                            {{$data['button']}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ asset('js/mainForm.js') }}"></script>

    <script>
        $(document).ready(function() {

            ///// VALIDATE /////
            $("#form").validate({
                highlight:function(input){
                    jQuery(input).addClass('is-invalid');
                },

                unhighlight:function(input){
                    jQuery(input).removeClass('is-invalid');
                    jQuery(input).addClass('is-valid');
                },

                errorPlacement:function(error, element)
                {
                    jQuery(element).parents('.form-group').find('#error').append(error);
                },
            })

        })
    </script>
@stop