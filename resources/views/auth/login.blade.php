@extends('layouts.login')

@section('content')
    <h1 class="title-login">Login</h1>

    <x-alert />

    <form class="mt-4" action="{{ route('login.process') }}" method="POST">
        @csrf
        @method('POST')

        <div class="form-group-login">
            <label for="email" class="form-label-login">E-mail</label>
            <input type="email" id="email" name="email" class="form-input-login" placeholder="Digite seu e-mail"
                value="{{ old('email') }}" required>
        </div>

        <div class="form-group-login">
            <label for="password" class="form-label-login">Senha</label>
            <input type="password" id="password" name="password" class="form-input-login" placeholder="Digite sua senha"
                value="{{ old('password') }}" required>
        </div>

        {{-- link para recuperação de senha e botao de login--}}
        <div class="btn-group-login">
            <a href="{{ route('password.request') }}" class="link-login">Esqueceu sua senha?</a>
            <button type="submit" class="btn-primary-md">Acessar</button>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('user.create') }}" class="link-login">Criar uma conta</a>

        </div>
    </form>
@endsection
