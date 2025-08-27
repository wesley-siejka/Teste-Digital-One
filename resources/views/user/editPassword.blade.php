@extends('layouts.admin')


@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Mudar senha</h1>
            <span>
                <a href="{{ route('user.show',['user' =>$user->id]) }}" class="btn-info">Vizualizar</a>
            </span>
        </div>

        <x-alert />

        <form action="{{ route('user.updatePassword', ['user' => $user->id]) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="current_password" class="form-label">Digite sua senha atual:</label>
                <input type="password" id="current_password" class="form-input" name="current_password"  placeholder="Digite sua senha atual" value="{{ old('current_password') }}">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Nova senha:</label>
                <input type="password" id="password" class="form-input" name="password" placeholder="Mínimo de 6 caracteres" value="{{ old('password') }}">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirme sua nova senha:</label>
                <input type="password" id="password_confirmation" class="form-input" name="password_confirmation"  placeholder="Confirme sua senha" value="{{ old('password_confirmation') }}">
            </div>

            <button type="submit" class="btn-success">Alterar Senha</button>
        </form>
    </div>
</div>
@endsection