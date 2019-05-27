@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>

            <div class="card-body">
                <form id="form" method="POST" action="{{url($data['url'])}}">
                    @csrf
                    
                    @if($data['method'])
                        @method($data['method'])
                    @endif

                    <h6>Dados Pessoais</h6>
                    <div class="form-group row">
                        <label for="usuario[nome]" class="col-md-4 col-form-label text-md-right">Nome</label>

                        <div class="col-md-6">
                            <input id="nome" type="text" class="form-control" name="usuario[nome]" value="{{old('usuario.nome', $data['usuario'] ? $data['usuario']->nome : '')}}">
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario.nome') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="usuario[email]" class="col-md-4 col-form-label text-md-right">E-mail</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="usuario[email]" value="{{old('usuario.email', $data['usuario'] ? $data['usuario']->email : '')}}">
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario.email') }}</small>
                        </div>
                    </div>

                    @if(!$data['usuario'])

                    <div class="form-group row">
                        <label for="usuario[password]" class="col-md-4 col-form-label text-md-right">Senha</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="usuario[password]" >
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario.password') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="usuario[password-confirm]" class="col-md-4 col-form-label text-md-right">Confirmar a Senha</label>
                        <div class="col-md-6">
                            <input id="passwordconfirm" type="password" class="form-control" name="usuario[password_confirmation]" >
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario.password_confirm') }}</small>
                        </div>
                    </div>

                    @endif

                    <div class="form-group row">
                        <label for="usuario[nivel_id]" class="col-md-4 col-form-label text-md-right">Nível</label>
                        <div class="col-md-6">
                            <select class="form-control" id="niveis" name="usuario[nivel_id]">
                                @foreach($data['niveis'] as $nivel)
                                    <option {{$nivel->id == old('usuario.nivel_id', $data['usuario'] ? $data['usuario']->nivel_id : '') ? 'selected' : '' }} value="{{$nivel->id}}">{{$nivel->nome}}</option>
                                @endforeach
                            </select>
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario.nivel_id') }}</small>
                        </div>
                    </div>

                    <div id="especializacoes" {{$data['usuario'] && $data['usuario']->nivel_id == 3 ? '' : 'hidden'}}>

                    <hr>
                    <h6>Especializações</h6>
                        
                        @foreach(old('especializacoes', $data['especializacoes_usuario']) as $offset => $especializacao_usuario)
                            <div class="form-group row esp">
                                <label class="col-md-4 col-form-label text-md-right">Especialização</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control especializacoes" id="especializacoes" name="especializacoes[{{$offset}}]" {{$data['usuario'] && $data['usuario']->nivel_id == 3 ? '' : 'disabled'}}>
                                            <option value="">Selecione</option>
                                            @foreach($data['especializacoes'] as $especializacao)
                                                <option value="{{$especializacao->id}}" {{$especializacao->id == (old('especializacoes') ? $especializacao_usuario : ($data['usuario'] ? $especializacao_usuario->id : '')) ? 'selected' : ''}} >{{$especializacao->especializacao}}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <span class="btn btn-outline-secondary add-esp"><i class="fa fa-plus"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacoes') }}</small>
                            </div>
                        @endforeach
                    </div>

                    <hr>
                    <h6>Dados de Endereço</h6>
                    
                    <div class="form-group row">
                        <label for="endereco[cep]" class="col-md-4 col-form-label text-md-right">CEP</label>
                        <div class="col-md-6">
                            <input id="cep" type="text" class="form-control cep" name="endereco[cep]" value="{{old('endereco.cep', $data['usuario'] ? $data['usuario']->endereco->cep : '')}}" >
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.cep') }}</small>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="endereco[estado_id]" class="col-md-4 col-form-label text-md-right">Estado</label>
                        <div class="col-md-6">
                            <select class="form-control" id="estado" name="endereco[estado_id]">
                                @foreach($data['estados'] as $estado)
                                    <option {{ $data['usuario'] && $estado->id == old('estado.id', $data['usuario']->endereco->cidade->estado_id) ? 'selected' : '' }} value="{{$estado->id}}">{{$estado->uf}}</option>
                                @endforeach
                            </select>
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.estado_id') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[cidade_id]" class="col-md-4 col-form-label text-md-right">Cidade</label>
                        <div class="col-md-6">
                            <select id="cidade" class="form-control" name="endereco[cidade_id]">
                                    @foreach($data['cidades'] as $cidade)
                                        <option {{ $data['usuario'] && $cidade->id == old('endereco.cidade_id', $data['usuario']->endereco->cidade_id) ? 'selected' : '' }} value="{{$cidade->id}}">{{$cidade->nome}}</option>
                                    @endforeach
                            </select>
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.cidade_id') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[bairro]" class="col-md-4 col-form-label text-md-right">Bairro</label>
                        <div class="col-md-6">
                            <input id="bairro" type="text" class="form-control" name="endereco[bairro]" value="{{old('endereco.bairro', $data['usuario'] ? $data['usuario']->endereco->bairro : '')}}">
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.bairro') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[logradouro]" class="col-md-4 col-form-label text-md-right">Logradouro</label>
                        <div class="col-md-6">
                            <input id="logradouro" type="text" class="form-control" name="endereco[logradouro]" value="{{old('endereco.logradouro', $data['usuario'] ? $data['usuario']->endereco->logradouro : '')}}" >
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.logradouro') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[numero]" class="col-md-4 col-form-label text-md-right">Número</label>
                        <div class="col-md-6">
                            <input id="numero" type="text" class="form-control" name="endereco[numero]" value="{{old('endereco.numero', $data['usuario'] ? $data['usuario']->endereco->numero : '')}}" >
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.numero') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[complemento]" class="col-md-4 col-form-label text-md-right">Complemento</label>
                        <div class="col-md-6">
                            <input id="complemento" type="text" class="form-control" name="endereco[complemento]" value="{{old('endereco.complemento', $data['usuario'] ? $data['usuario']->endereco->complemento : '')}}">
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.complemento') }}</small>
                        </div>
                    </div>

                    <hr>
                    <h6>Telefones</h6>

                    <div id="telefones">

                        @foreach(old('telefone', $data['telefones']) as $offset => $telefone)
                        
                        <div class="form-group row tel">
                            <label for="telefone[{{$offset}}][numero]" class="col-md-4 col-form-label text-md-right">Telefone</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    @if($data['usuario'])
                                        <input type="hidden" name="telefone[{{$offset}}][id]" value="{{isset($telefone->id) ? $telefone->id : ''}}">
                                    @endif
                                    <input type="text" class="form-control telefone" name="telefone[{{$offset}}][numero]" value="{{$telefone['numero'] ? $telefone['numero'] : ''}}"> 
                                    <div class="input-group-append">
                                        <span class="btn btn-outline-secondary add-tel"><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <small id="error" id="error" class="errors font-text text-danger">{{ $errors->first('telefone.'.$offset.'.numero') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <h6>Documentos</h6>

                    <div id="documentos">

                        @foreach(old('documentos', $data['documentos']) as $offset => $documento)
                        
                        <div class="form-group row doc">
                            <label for="documento[{{$offset}}][numero]" class="col-md-4 col-form-label text-md-right">Documento</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    @if($data['usuario'])
                                        <input type="hidden" name="documento[{{$offset}}][id]" value="{{isset($documento->id) ? $documento->id : ''}}">
                                    @endif
                                    <select class="form-control"  name="documento[{{$offset}}][tipo]" id="exampleFormControlSelect1">
                                        @foreach($data['tipoDocumentos'] as $tipoDocumento)
                                        <option value="{{$tipoDocumento->id}}">{{$tipoDocumento->tipo}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" placeholder="Numero" class="form-control documento" name="documento[{{$offset}}][numero]" value="{{$documento['numero'] ? $documento['numero'] : ''}}"> 
                                    <div class="input-group-append">
                                        <span class="btn btn-outline-secondary add-doc"><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <small id="error" id="error" class="errors font-text text-danger">{{ $errors->first('documento.'.$offset.'.numero') }}</small>
                            </div>
                        </div>
                        @endforeach

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
    <script type="text/javascript" src="{{ asset('js/jquery-validator/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            //INSERINDO OS BOTÕES DE DELETAR NO CARREGAMENTO DA PÁGINA
            let newSufix = ""
            $('span[class*="add-"]').each(function(i, e) {
                let sufix = $(e).attr('class').match('add-[^-]*$')[0].split('-')[1]
                if(sufix !== newSufix) {
                    i = 0
                }
                if(i > 0) {
                    $(e).removeClass('add-'+sufix)
                        .addClass('del-'+sufix)
                        .find('i')
                        .removeClass('fa-plus')
                        .addClass('fa-trash') 
                }
                newSufix = sufix
            })

            if($('#niveis').find('option:selected').val() == '3') {
                $('select.especializacoes').removeAttr('disabled')
                $('#especializacoes').removeAttr('hidden')
                $('select.especializacoes').prop('required',true);
            } else {
                $('select.especializacoes').attr('disabled', 'disabled')
                $('#especializacoes').attr('hidden', 'hidden')
            }
        
        })

        $(document).on('change', '#niveis', function() {
            if($(this).find('option:selected').val() == '3') {
                $('select.especializacoes').removeAttr('disabled')
                $('#especializacoes').removeAttr('hidden')
                $('select.especializacoes').prop('required',true);
            } else {
                $('select.especializacoes').attr('disabled', 'disabled')
                $('#especializacoes').attr('hidden', 'hidden')
            }
        })

        function clonar(target, local, indices) {
            $(target).last().clone().appendTo(local).hide().fadeIn()

            if(indices) {
                $(target).last().find('input, select').each(function() {
                    var index = $(this).attr('name').split('[')[1].split(']')[0]
                    $(this).attr('name', $(this).attr('name').replace(index, parseInt(index) + 1))
                })
            }
        }

        function remover(target, buttonClicked) {
            $(buttonClicked).closest(target).fadeOut('fast')
        }

        $(document).on('click', '.add-tel', function() {
            if($('.tel').length < 4) {
                clonar('.tel', '#telefones', true)
                $('.tel').last().find('input').val('')
                mascararTel($('.tel').last().find('input'))
                $('.tel').last().find('.add-tel')
                    .removeClass('add-tel')
                    .addClass('del-tel')
                    .find('i')
                    .removeClass('fa fa-plus')
                    .addClass('fa fa-trash')
            } else {
                alert('Podem ser adicionados no máximo '+$(".tel").length+' telefones')
            }
        })

        $(document).on("click", ".del-tel", function() {
            if($(".tel").length > 1) {
                remover(".tel", $(this))
            } else {
                alert('Deve conter no mínimo 1 telefone')
            }
        })

        $(document).on('click', '.add-esp', function() {
            if($('.esp').length < 10) {
                clonar('.esp', '#especializacoes', true)
                $('.esp').last().find('.add-esp')
                    .removeClass('add-esp')
                    .addClass('del-esp')
                    .find('i')
                    .removeClass('fa fa-plus')
                    .addClass('fa fa-trash')
            } else {
                alert('Podem ser adicionados no máximo '+$(".esp").length+' especializações')
            }
        })

        $(document).on("click", ".del-esp", function() {
            if($(".esp").length > 1) {
                remover(".esp", $(this))
            } else {
                alert('Deve conter no mínimo 1 especialização')
            }
        })

        $(document).on('click', '.add-doc', function() {
            if($('.doc').length < 10) {
                clonar('.doc', '#documentos', true)
                $('.doc').last().find('.add-doc')
                    .removeClass('add-doc')
                    .addClass('del-doc')
                    .find('i')
                    .removeClass('fa fa-plus')
                    .addClass('fa fa-trash')
            } else {
                alert('Podem ser adicionados no máximo '+$(".doc").length+' documentos')
            }
        })

        $(document).on("click", ".del-doc", function() {
            if($(".doc").length > 1) {
                remover(".doc", $(this))
            } else {
                alert('Deve conter no mínimo 1 documentos')
            }
        })

        $(document).on('click', '.send-form', function() {
            if($("#form").valid()){
                $(".send-form").prop("disabled",true) 
                $("#form").submit()
            }
        })

        //MÁSCARAS
        function mascararTel(input) {
            $(input).last().mask('(00) 0000-00009');
            $(input).last().keyup(function(event) {
                if($(this).val().length == 15){
                        $(input).last().mask('(00) 00000-0009');
                } else {
                        $(input).last().mask('(00) 0000-00009');
                }
            });
        }

        $('.cep').mask('00000-000')
        $('.telefone').each(function(i,tel){
            mascararTel(tel)
        })

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

            rules: {
                "usuario[nome]": "required",

                "usuario[email]": {
                    required:true,
                    email:true, 
                },
            
                "usuario[password]": {
                    required: true,
					minlength: 6,
                    maxlength: 10
                },

                "usuario[password_confirmation]":{
                    required: true,
					minlength: 6,
                    maxlength: 10,
					equalTo: "#password"
                },

                "usuario[nivel_id]": "required",
                "endereco[cep]": "required",
                "endereco[estado]": "required",
                "endereco[cidade]": "required",
                "endereco[bairro]": { required: true, maxlength: 100 },
                "endereco[logradouro]": { required: true, maxlength:100 },
                "endereco[numero]":{ required: true, digits: true },
                "endereco[complemento]": { required: true, maxlength:255 },
                "telefone[numero]": { required: true, minlength:10, maxlength:11 }

            },

            messages: {

                "usuario[nome]":{
                    required: 'Este campo é obrigatório',
                },

                "usuario[email]":{
                    email:'Digite um email válido', 
                    required: 'O campo e-mail é obrigatório',
                },

                "usuario[password]":{
                    required:  'Este campo é obrigatório',
                    minlength: 'Sua senha deve ter pelo menos 6 caracteres.',
                    maxlength: 'Sua senha não deve ter mais de 10 caracteres'

                },

                "usuario[password_confirmation]":{
                    required: 'Este campo é obrigatório',
                    minlength: 'Sua senha deve ter pelo menos 6 caracteres.',
                    maxlength: 'Sua senha não deve ter mais de 10 caracteres',
					equalTo: 'As duas senhas devem ser iguais'
                },

                "usuario[nivel_id]": { 
                    required: 'Este campo é obrigatório'
                },
                
                "endereco[cep]": {
                    required: 'Este campo é obrigatório'
                },
                
                "endereco[estado]": {
                    required: 'Este campo é obrigatório'
                },
                
                "endereco[cidade]": {
                    required: 'Este campo é obrigatório'
                },
                
                "endereco[bairro]": {
                    required: 'Este campo é obrigatório',
                    maxlength: 'Este campo não pode ter mais de 100 caracteres'
                },

                "endereco[logradouro]":{
                    required: 'Este campo é obrigatório',
                    maxlength: 'Este campo não pode ter mais de 100 caracteres'
                },

                "endereco[numero]":{
                    required: 'O campo número é obrigatório',
                    digits:   'Este campo deve ter somente valores numericos',
                },

                "endereco[complemento]": { 
                    required: 'Este campo é obrigatório' 
                },

                "telefone[numero]": { 
                    required: 'Este campo é obrigatório',
                    minlength: 'Este campo deve ter pelo menos 10 caracteres',
                    maxlength: 'Este campo não pode passar de 11 caracteres'
                },
            },
        });

    </script>
@stop