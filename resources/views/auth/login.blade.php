@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white h5">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf

                        <div class="form-group">

                            <label for="email" class="col-md-4 col-form-label">E-mail</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-user"></i></span>
                                </div>
                                <input id="email" type="email" class="form-control" name="email" value="{{old('email') }}" required>
                                </div>
                                <small id="error" class="errors font-text text-danger">{{ $errors->first('email') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 col-form-label">Senha</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-lock"></i></span>
                                </div>
                               <input id="password" type="password" class="form-control" name="password" required">
                            </div>
                             <small id="error" class="errors font-text text-danger">{{ $errors->first('email') }}</small>
                        </div>

                        <div class="form-group text-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info">
                                    ENTRAR
                                </button>
                            </div>
                            <div class="col-md-12">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Esqueceu sua senha?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
