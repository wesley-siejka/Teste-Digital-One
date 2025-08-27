@extends('layouts.login')


@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Cadastrar Usuário</h1>
        </div>

        <x-alert />

        <form action="{{ route('user.store') }}" method="POST" class="mt-4">
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label-login">Nome:</label>
                <input type="text" id="name" class="form-input-login" name="name"  placeholder="Digite seu nome" value="{{ old('name') }}">
            </div>

            <div class="mb-4">
                <label for="email" class="form-label-login">Email:</label>
                <input type="email" id="email" class="form-input-login" name="email" placeholder="Digite seu email" value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label-login">Senha:</label>
                <input type="password" id="password" class="form-input-login" name="password"  placeholder="Mínimo de 6 caracteres" value="{{ old('password') }}">
            </div>

            <div class="btn-group-login">
            <a href="{{ route('login') }}" class="link-login">Login</a>
            <button type="submit" class="btn-success">Cadastrar</button>
            </div>
        </form>
    </div>
</div>
@endsection