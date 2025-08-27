@extends('layouts.admin')


@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Editar</h1>
            <span>
                <a href="{{ route('user.show',['user' =>$user->id]) }}" class="btn-info">Vizualizar</a>
            </span>
        </div>

        <x-alert />

        <form action="{{ route('user.update', ['user' => $user->id]) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" id="name" class="form-input" name="name"  placeholder="Digite seu nome" value="{{ old('name', $user->name) }}">
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" id="email" class="form-input" name="email" placeholder="Digite seu e-mail" value="{{ old('email', $user->email) }}">
            </div>

            <button type="submit" class="btn-success">Salvar</button>
        </form>
    </div>
</div>
@endsection