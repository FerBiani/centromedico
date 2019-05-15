@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>

            <div class="card-body">
                <form method="POST" action="{{url($data['url'])}}">
                    @csrf
                    @if(isset($data['method']))
                        @method($data['method'])
                    @endif

                    <h6>Dados Pessoais</h6>
                    <div class="form-group row">
                        <label for="usuario[nome]" class="col-md-4 col-form-label text-md-right">Nome</label>

                        <div class="col-md-6">
                            <input id="nome" type="text" class="form-control" name="usuario[nome]" value="{{$data['usuario'] ? $data['usuario']->nome : '' }}">
                            <small class="errors font-text text-danger">{{ $errors->first('usuario.nome') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="usuario[email]" class="col-md-4 col-form-label text-md-right">E-mail</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="usuario[email]" value="{{$data['usuario'] ? $data['usuario']->email : '' }}" >
                            <small class="errors font-text text-danger">{{ $errors->first('usuario.email') }}</small>
                        </div>
                    </div>

                    @if(!$data['usuario'])

                    <div class="form-group row">
                        <label for="usuario[password]" class="col-md-4 col-form-label text-md-right">Senha</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="usuario[password]" >
                            <small class="errors font-text text-danger">{{ $errors->first('usuario.password') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="usuario[password-confirm]" class="col-md-4 col-form-label text-md-right">Confirmar a Senha</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="usuario[password_confirmation]" >
                        </div>
                    </div>

                    @endif

                    <div class="form-group row">
                        <label for="usuario[nivel_id]" class="col-md-4 col-form-label text-md-right">Nível</label>
                        <div class="col-md-6">
                            <select  class="form-control" id="niveis" name="usuario[nivel_id]">
                                @foreach($data['niveis'] as $nivel)
                                    <option value="{{$nivel->id}}">{{$nivel->nome}}</option>
                                @endforeach
                            </select>
                            <small class="errors font-text text-danger">{{ $errors->first('usuario.nivel_id') }}</small>
                        </div>
                    </div>

                    <?php

                        if($data['usuario'] && $data['usuario']->nivel_id == 3) {
                            $especializacoes_usuario = $data['usuario']->especializacoes;
                        } else {
                            $especializacoes_usuario = ['especializacoes'];
                        }

                    ?>

                     <div class="especializacoes" {{$data['usuario'] && $data['usuario']->nivel_id == 3 ? '' : 'hidden'}}>
                            @foreach($especializacoes_usuario as $especializacao_usuario)
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">Especialização</label>
                                    <div class="col-md-6">
                                        <select class="form-control especializacoes" name="especializacoes['id']" $data['usuario'] && $data['usuario']->nivel_id == 3 ? '' : 'disabled'>
                                            @foreach($data['especializacoes'] as $especializacao)
                                                <option value="{{$especializacao->id}}" {{($data['usuario'] && $data['usuario']->nivel_id == 3 && $especializacao_usuario->id == $especializacao->id) ? 'selected' : ''}}>{{$especializacao->especializacao}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <i id="add-especializacao" class="fa fa-plus"></i>
                                    </div>
                                </div>
                            @endforeach
                        <small class="errors font-text text-danger">{{ $errors->first('usuario.especializacoes') }}</small>
                    </div>

                    <hr>
                    <h6>Dados de Endereço</h6>
                    
                    <div class="form-group row">
                        <label for="endereco[cep]" class="col-md-4 col-form-label text-md-right">CEP</label>
                        <div class="col-md-6">
                            <input id="cep" type="text" class="form-control" name="endereco[cep]" value="{{$data['usuario'] ? $data['usuario']->endereco->cep : ''}}" >
                            <small class="errors font-text text-danger">{{ $errors->first('endereco.cep') }}</small>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="endereco[estado_id]" class="col-md-4 col-form-label text-md-right">Estado</label>
                        <div class="col-md-6">
                            <select  class="form-control @error('estados_id') is-invalid @enderror" name="endereco[estado_id]">
                                @foreach($data['estados'] as $estado)
                                    <option value="{{$estado->id}}">{{$estado->uf}}</option>
                                @endforeach
                            </select>
                            <small id="NomeHelp" class="errors font-text text-danger">{{ $errors->first('endereco.estado_id') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[cidade_id]" class="col-md-4 col-form-label text-md-right">Cidade</label>
                        <div class="col-md-6">
                        <select  class="form-control" name="endereco[cidade_id]">
                                @foreach($data['cidades'] as $cidade)
                                    <option value="{{$cidade->id}}">{{$cidade->nome}}</option>
                                @endforeach
                        </select>
                        <small class="errors font-text text-danger">{{ $errors->first('endereco.cidade_id') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[bairro]" class="col-md-4 col-form-label text-md-right">Bairro</label>
                        <div class="col-md-6">
                            <input id="bairro" type="text" class="form-control" name="endereco[bairro]" value="{{$data['usuario'] ? $data['usuario']->endereco->bairro : ''}}" >
                            <small class="errors font-text text-danger">{{ $errors->first('endereco.bairro') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[logradouro]" class="col-md-4 col-form-label text-md-right">Logradouro</label>
                        <div class="col-md-6">
                            <input id="logradouro" type="text" class="form-control" name="endereco[logradouro]" value="{{$data['usuario'] ? $data['usuario']->endereco->logradouro : ''}}" >
                            <small class="errors font-text text-danger">{{ $errors->first('endereco.logradouro') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[numero]" class="col-md-4 col-form-label text-md-right">Número</label>
                        <div class="col-md-6">
                            <input id="numero" type="text" class="form-control" name="endereco[numero]" value="{{$data['usuario'] ? $data['usuario']->endereco->numero : ''}}" >
                            <small class="errors font-text text-danger">{{ $errors->first('endereco.numero') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[complemento]" class="col-md-4 col-form-label text-md-right">Complemento</label>
                        <div class="col-md-6">
                            <input id="complemento" type="text" class="form-control" name="endereco[complemento]" value="{{$data['usuario'] ? $data['usuario']->endereco->complemento : ''}}" >
                            <small class="errors font-text text-danger">{{ $errors->first('endereco.complemento') }}</small>
                        </div>
                    </div>

                    <hr>
                    <h6>Telefones</h6>
                    
                    <div class="form-group row">
                        <label for="telefone[numero]" class="col-md-4 col-form-label text-md-right">Telefone</label>
                        <div class="col-md-6">
                            <input id="telefone" type="text" class="form-control" name="telefone[numero]" > 
                            <small class="errors font-text text-danger">{{ $errors->first('telefone.numero') }}</small>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Cadastrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).on('change', '#niveis', function() {
            if($(this).find('option:selected').val() == '3') {
                $('select.especializacoes').removeAttr('disabled')
                $('div.especializacoes').removeAttr('hidden')
            } else {
                $('select.especializacoes').attr('disabled', 'disabled')
                $('div.especializacoes').attr('hidden', 'hidden')
            }
        })
    </script>
@stop