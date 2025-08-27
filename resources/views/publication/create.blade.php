@extends('layouts.admin')

@section('content')
<div class="content">
    <h1 class="page-title">Nova Publicação</h1>
    <x-alert />
    <form action="{{ route('publication.store') }}" method="POST" class="form-container">
        @csrf
        <div class="mb-4">
            <label for="title" class="form-label">Título</label>
            <input type="text" id="title" placeholder="Digite o título da publicação" name="title" class="form-input" value="{{ old('title') }}">
        </div>
        <div class="mb-4">
            <label for="content" class="form-label">Comentário</label>
            <input type="text" id="content" placeholder="Comente sobre a publicação" name="content" class="form-input " value="{{ old('content') }}">
        </div>
        <div class="mb-4">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-input">
                <option value="public" {{ old('status') == 'public' ? 'selected' : '' }}>Público</option>
                <option value="private" {{ old('status') == 'private' ? 'selected' : '' }}>Privado</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-success">Salvar</button>
            <a href="{{ route('publication.index') }}" class="btn-warning">Cancelar</a>
        </div>
    </form>
</div>
@endsection