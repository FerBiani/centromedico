@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white h5">{{$data['title']}}</div>

            <div class="card-body">
                <form id="form" method="POST" action="{{url($data['url'])}}" autocomplete="off">
                    @csrf

                    @foreach($errors->all() as $error) 
                        <span>{{$error}}</span>
                    @endforeach
                    
                    @if($data['method'])
                        @method($data['method'])
                    @endif

                    @if($data['usuario'])
                        <input type="hidden" id="nivel_id_fixed" name="usuario[nivel_id]" value="{{$data['usuario']->nivel_id}}">
                    @endif

                    <h6>Dados Básicos</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario[nome]" class="col-form-label">Nome</label>
                                <input id="nome" type="text" class="form-control" name="usuario[nome]" value="{{old('usuario.nome', $data['usuario'] ? $data['usuario']->nome : '')}}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario.nome') }}</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario[email]" class="col-form-label">E-mail</label>
                                <input id="email" type="email" class="form-control" name="usuario[email]" value="{{old('usuario.email', $data['usuario'] ? $data['usuario']->email : '')}}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario.email') }}</small>
                            </div>
                        </div>
                    </div>

                    @if(!$data['usuario'])
                    <hr>
                    <h6>Nível e Segurança</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario[password]" class="col-form-label">Senha</label>
                                <input id="password" type="password" class="form-control" name="usuario[password]" >
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario.password') }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario[password-confirm]" class="col-form-label">Confirmar a Senha</label>
                                <input id="passwordconfirm" type="password" class="form-control" name="usuario[password_confirmation]" >
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario.password_confirm') }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario[nivel_id]" class="col-form-label">Nível</label>
                                <select class="form-control" id="niveis" name="usuario[nivel_id]">
                                    @foreach($data['niveis'] as $nivel)
                                        <option {{$nivel->id == old('usuario.nivel_id', $data['usuario'] ? $data['usuario']->nivel_id : '') ? 'selected' : '' }} value="{{$nivel->id}}">{{$nivel->nome}}</option>
                                    @endforeach
                                </select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('usuario.nivel_id') }}</small>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div id="especializacoes" {{$data['usuario'] && $data['usuario']->nivel_id == 3 ? '' : 'hidden'}}>
                        <hr>
                        <h6>Especializações</h6>
                        @foreach($data['especializacoes_usuario'] as $offset => $especializacao_usuario)
                            <div class="row esp">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label ">Especialização</label>
                                        <div class="input-group">
                                            <select class="form-control especializacoes" name="especializacoes[{{$offset}}][especializacao_id]" required>
                                                <option disabled selected>Selecione</option>
                                                @foreach($data['especializacoes'] as $especializacao)
                                                    <option value="{{$especializacao->id}}" {{$especializacao_usuario['pivot']['especializacao_id'] == $especializacao->id ? 'selected' : ''}}>{{$especializacao->especializacao}}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <span class="btn btn-outline-secondary add-esp"><i class="fa fa-plus"></i></span>
                                            </div>
                                        </div>
                                        <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacoes'.$offset.'.especializacao_id') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mt-2">
                                        <label for="retorno[tempo_retorno]">Tempo de retorno (em dias)</label>
                                        <input type="text" class="form-control tempo_retorno" name="especializacoes[{{$offset}}][tempo_retorno]" value="{{$especializacao_usuario['pivot']['tempo_retorno']}}" required>
                                        <small id="error" class="errors font-text text-danger">{{ $errors->first('especializacoes.'.$offset.'.tempo_retorno') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>
                    <h6>Dados de Endereço</h6>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="endereco[cep]" class="col-form-label">CEP</label>
                                <input id="cep" type="text" class="form-control cep" name="endereco[cep]" value="{{old('endereco.cep', $data['usuario'] ? $data['usuario']->endereco->cep : '')}}" >
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.cep') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="endereco[estado_id]" class="col-form-label">Estado</label>
                                <select class="form-control estados" id="estado_id" name="endereco[estado_id]">
                                    @foreach($data['estados'] as $estado)
                                        <option {{ $data['usuario'] && $estado->id == old('estado.id', $data['usuario'] ? $data['usuario']->endereco->estado_id : '') ? 'selected' : '' }} value="{{$estado->id}}">{{$estado->uf}}</option>
                                    @endforeach
                                </select>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.estado_id') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="endereco[cidade]" class="col-form-label">Cidade</label>              
                                <input id="cidade" type="text" class="form-control" name="endereco[cidade]" value="{{old('endereco.cidade', $data['usuario'] ? $data['usuario']->endereco->cidade : '')}}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.cidade') }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="endereco[bairro]" class="col-form-label">Bairro</label>
                                <input id="bairro" type="text" class="form-control" name="endereco[bairro]" value="{{old('endereco.bairro', $data['usuario'] ? $data['usuario']->endereco->bairro : '')}}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.bairro') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="endereco[logradouro]" class="col-form-label">Logradouro</label>
                                <input id="logradouro" type="text" class="form-control" name="endereco[logradouro]" value="{{old('endereco.logradouro', $data['usuario'] ? $data['usuario']->endereco->logradouro : '')}}" >
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.logradouro') }}</small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="endereco[numero]" class="col-form-label">Número</label>
                                <input id="numero" type="text" class="form-control" name="endereco[numero]" value="{{old('endereco.numero', $data['usuario'] ? $data['usuario']->endereco->numero : '')}}" >
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.numero') }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="endereco[complemento]" class="col-form-label">Complemento</label>
                                <input id="complemento" type="text" class="form-control" name="endereco[complemento]" value="{{old('endereco.complemento', $data['usuario'] ? $data['usuario']->endereco->complemento : '')}}">
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('endereco.complemento') }}</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6>Telefones</h6>
                    <div id="telefones">

                        @foreach(old('telefone', $data['telefones']) as $offset => $telefone)
                        <div class="row tel">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="telefone[{{$offset}}][numero]" class="col-form-label">Número</label> 
                                    <div class="input-group">
                                        @if($data['usuario'])
                                            <input type="hidden" name="telefone[{{$offset}}][id]" value="{{isset($telefone['id']) ? $telefone['id'] : ''}}">
                                        @endif
                                        <input type="text" class="form-control telefone" name="telefone[{{$offset}}][numero]" value="{{$telefone['numero'] ? $telefone['numero'] : ''}}"> 
                                        <div class="input-group-append">
                                            <span class="btn btn-outline-secondary add-tel"><i class="fa fa-plus"></i></span>
                                        </div>
                                    </div>
                                    <small id="error" id="error" class="errors font-text text-danger">{{ $errors->first('telefone.'.$offset.'.numero') }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <h6>Documentos</h6>

                    <div id="documentos">

                        @foreach(old('documento', $data['documentos']) as $offset => $documento)
                        <div class="row doc">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="documento[{{$offset}}][numero]" class="col-form-label">Tipo</label>
                                    <div class="input-group">
                                        @if($data['usuario'])
                                            <input type="hidden" name="documento[{{$offset}}][id]" value="{{isset($documento['id']) ? $documento['id'] : ''}}">
                                        @endif
                                        <select class="form-control documento select-documentos" name="documento[{{$offset}}][tipo_documentos_id]">
                                            @foreach(\App\TipoDocumento::all() as $tipoDocumento)
                                                @if($tipoDocumento->id != 4)
                                                    <option {{$documento['tipo_documentos_id'] == $tipoDocumento->id ? 'selected' : ''}} value="{{$tipoDocumento->id}}">{{$tipoDocumento->tipo}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="documento[{{$offset}}][numero]" class="col-form-label">Documento</label>
                                    <div class="input-group">
                                        <input type="text" placeholder="Numero" class="form-control documento" name="documento[{{$offset}}][numero]" value="{{$documento['numero'] ? $documento['numero'] : ''}}" required> 
                                        <div class="input-group-append">
                                            <span class="btn btn-outline-secondary add-doc"><i class="fa fa-plus"></i></span>
                                        </div>
                                    </div>
                                    <small id="error" class="errors font-text text-danger">{{ $errors->first('documento.'.$offset.'.numero') }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- CRM -->
                    <div id="crm" class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">CRM</label>
                                @if($data['usuario'])
                                    <input type="hidden" name="crm[id]" value="{{$data['usuario'] && $data['usuario']->getCRM() ? $data['usuario']->getCRM()->id : ''}}">
                                @endif
                                <input type="hidden" name="crm[tipo_documentos_id]">
                                <input type="text" placeholder="Numero" class="form-control" name="crm[numero]" value="{{old('crm.numero', $data['usuario'] && $data['usuario']->getCRM() ? $data['usuario']->getCRM()->numero : '')}}" required>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('crm.numero') }}</small>
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
    <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/mainForm.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/usuario/form.js') }}"></script>
@stop