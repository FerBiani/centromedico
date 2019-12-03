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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="especializacao[especializacao]" class="col-form-label">Especialização</label>
                                <input id="especializacao" type="text" class="form-control" name="especializacao[especializacao]" value="{{old('especializacao.especializacao', $data['especializacao'] ? $data['especializacao']->especializacao : '')}}" required>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacao.especializacao') }}</small>
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