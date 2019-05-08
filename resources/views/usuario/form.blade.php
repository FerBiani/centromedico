@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>

            <div class="card-body">
                <form method="POST" action="{{url($data['url'])}}">
                    @csrf
                    <div class="form-group row">
                        <label for="usuario[nome]" class="col-md-4 col-form-label text-md-right">Nome</label>

                        <div class="col-md-6">
                            <input id="nome" type="text" class="form-control" name="usuario[nome]" value="{{old('nome') }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="usuario[email]" class="col-md-4 col-form-label text-md-right">E-mail</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="usuario[email]" value="{{old('email')}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="usuario[password]" class="col-md-4 col-form-label text-md-right">Senha</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="usuario[password]" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="usuario[password-confirm]" class="col-md-4 col-form-label text-md-right">Confirmar a Senha</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="usuario[password_confirmation]" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="usuario[nivel_id]" class="col-md-4 col-form-label text-md-right">Nível</label>

                        <div class="col-md-6">
                            <select required class="form-control" name="usuario[nivel_id]">
                                @foreach($data['niveis'] as $nivel)
                                    <option value="{{$nivel->id}}">{{$nivel->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr>
                    <h6>Dados de Endereço</h6>
                    <div class="form-group row">
                        <label for="endereco[cep]" class="col-md-4 col-form-label text-md-right">CEP</label>

                        <div class="col-md-6">
                            <input id="cep" type="text" class="form-control" name="endereco[cep]" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="endereco[estado_id]" class="col-md-4 col-form-label text-md-right">Estado</label>
                        <div class="col-md-6">
                            <select required class="form-control @error('estados_id') is-invalid @enderror" name="endereco[estado_id]">
                                @foreach($data['estados'] as $estado)
                                    <option value="{{$estado->id}}">{{$estado->uf}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="endereco[cidade_id]" class="col-md-4 col-form-label text-md-right">Cidade</label>

                        <div class="col-md-6">
                        <select required class="form-control" name="endereco[cidade_id]">
                                @foreach($data['cidades'] as $cidade)
                                    <option value="{{$cidade->id}}">{{$cidade->nome}}</option>
                                @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="endereco[bairro]" class="col-md-4 col-form-label text-md-right">Bairro</label>

                        <div class="col-md-6">
                            <input id="bairro" type="text" class="form-control" name="endereco[bairro]" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[logradouro]" class="col-md-4 col-form-label text-md-right">Logradouro</label>

                        <div class="col-md-6">
                            <input id="logradouro" type="text" class="form-control" name="endereco[logradouro]" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[numero]" class="col-md-4 col-form-label text-md-right">Número</label>

                        <div class="col-md-6">
                            <input id="numero" type="text" class="form-control" name="endereco[numero]" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco[complemento]" class="col-md-4 col-form-label text-md-right">Complemento</label>

                        <div class="col-md-6">
                            <input id="complemento" type="text" class="form-control" name="endereco[complemento]" required>
                        </div>
                    </div>

                    <hr>
                    <h6>Telefones</h6>
                    
                    <div class="form-group row">
                        <label for="telefone[numero]" class="col-md-4 col-form-label text-md-right">Telefone</label>

                        <div class="col-md-6">
                            <input id="telefone" type="text" class="form-control" name="telefone[numero]" required>
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