@extends('layouts.admin')

@section('content')
    <div class="content">
        <h1 class="page-title">Editar Publicação</h1>
        <x-alert />
        <form action="{{ route('publication.update', $publication->id) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="form-label">Título</label>
                <input type="text" id="title" name="title" class="form-input"
                    value="{{ old('title', $publication->title) }}" required>
            </div>
            <div class="mb-4">
                <label for="content" class="form-label">Comentário</label>
                <textarea id="content" name="content" class="form-input" required>{{ old('content', $publication->content) }}</textarea>
            </div>
            <div class="mb-4">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-input" required>
                    <option value="public" {{ old('status', $publication->status) == 'public' ? 'selected' : '' }}>Público
                    </option>
                    <option value="private" {{ old('status', $publication->status) == 'private' ? 'selected' : '' }}>Privado
                    </option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-success">Salvar</button>
                <a href="{{ route('publication.index') }}" class="btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
