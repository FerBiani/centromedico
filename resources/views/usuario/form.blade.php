@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">{{$data['title']}}</div>

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
                    @endif

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
                            <select class="form-control estados" id="estado_id" name="endereco[estado_id]">
                                @foreach($data['estados'] as $estado)
                                    <option {{ $data['usuario'] && $estado->id == old('estado.id', $data['usuario']->endereco->estado_id) ? 'selected' : '' }} value="{{$estado->id}}">{{$estado->uf}}</option>
                                @endforeach
                            </select>
                            <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.estado_id') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[cidade]" class="col-md-4 col-form-label text-md-right">Cidade</label>
                        <div class="col-md-6">                        
                        <input id="cidade" type="text" class="form-control" name="endereco[cidade]" value="{{old('endereco.cidade', $data['usuario'] ? $data['usuario']->endereco->cidade : '')}}">
                        <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.cidade') }}</small>
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

                        @foreach(old('documento', $data['documentos']) as $offset => $documento)
                        
                        <div class="form-group row doc">
                            <label for="documento[{{$offset}}][numero]" class="col-md-4 col-form-label text-md-right">Documento</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    @if($data['usuario'])
                                        <input type="hidden" name="documento[{{$offset}}][id]" value="{{isset($documento->id) ? $documento->id : ''}}">
                                    @endif
                                    <select class="form-control documento" name="documento[{{$offset}}][tipo_documentos_id]">
                                        @foreach(\App\TipoDocumento::all() as $tipoDocumento)
                                        <option {{$documento->tipo_documentos_id == $tipoDocumento->id ? 'selected' : ''}} value="{{$tipoDocumento->id}}">{{$tipoDocumento->tipo}}</option>
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
    <script type="text/javascript" src="{{ asset('js/mainForm.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/usuario/form.js') }}"></script>
@stop