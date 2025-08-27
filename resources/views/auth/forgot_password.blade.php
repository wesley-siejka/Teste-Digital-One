@extends('layouts.login')

@section('content')
    <h1 class="title-login">Recuperar a Senha</h1>

    <x-alert />

    <form class="mt-4" action="{{ route('password.email') }}" method="POST">
        @csrf
        @method('POST')

        {{-- campo e-mail --}}
        <div class="form-group-login">
            <label for="email" class="form-label-login">E-mail</label>
            <input type="email" id="email" name="email" class="form-input-login" placeholder="Digite seu e-mail"
                value="{{ old('email') }}" required>
        </div>

        {{-- link para pagina de login--}}
        <div class="btn-group-login">
            <a href="{{ route('login') }}" class="link-login">Login</a>
            <button type="submit" class="btn-primary-md">Recuperar</button>
        </div>

    </form>
@endsection
