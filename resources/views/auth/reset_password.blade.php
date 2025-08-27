@extends('layouts.login')

@section('content')
    <h1 class="title-login">Nova Senha</h1>

    <x-alert />

    <form class="mt-4" action="{{ route('password.update') }}" method="POST">
        @csrf
        @method('POST')

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        {{-- campo senha --}}
        <div class="form-group-login">
            <label for="password" class="form-label-login">Senha</label>
            <input type="password" id="password" name="password" class="form-input-login" placeholder="Digite sua nova senha"
                value="{{ old('password') }}" required>
        </div>

        {{-- campo confirmar senha --}}
        <div class="form-group-login">
            <label for="password_confirmation" class="form-label-login">Confirmar Senha</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input-login" placeholder="Confirme sua nova senha"
                value="{{ old('password_confirmation') }}" required>
        </div>

        {{-- link para pagina de login--}}
        <div class="btn-group-login">
            <a href="{{ route('login') }}" class="link-login">Login</a>
            <button type="submit" class="btn-primary-md">Atualizar</button>
        </div>
    </form>
@endsection
