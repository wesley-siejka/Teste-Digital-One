@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Comentários</h1>
            <a href="{{ route('publication.create') }}" class="btn-success">Nova Publicação</a>
        </div>

        <x-alert />

        <form class="pb-3 grid xl:grid-cols-5 md:grid-cols-2 gap-2 items-end">
            <input type="text" name="pesquisar" class="form-input" placeholder="Pesquisar" value="{{ $pesquisar }}">
            <select name="filtro" class="form-input">
                <option value="todos" {{ $filtro == 'todos' ? 'selected' : '' }}>Todos</option>
                <option value="meus" {{ $filtro == 'meus' ? 'selected' : '' }}>Meus comentários</option>
            </select>
            <div class="flex gap-1">
                <button type="submit" class="btn-primary">
                    <span>Pesquisar</span>
                </button>
                <a href="{{ route('publication.index') }}" class="btn-warning">Limpar</a>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse ($publications as $publication)
                <div class="card-login mb-4">
                    <div class="card-header flex justify-between items-center">
                        <span class="font-bold text-lg">{{ $publication->title }}</span>
                        <span class="badge {{ $publication->status == 'public' ? 'status-public' : 'status-private' }}">
                            {{ ucfirst($publication->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="mb-2 ">{{ $publication->content }}</p>
                        <small class="text-gray-600">
                            Autor: {{ $publication->user->name }} <br>
                            Criado em: {{ $publication->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    @if ($publication->user_id === Auth::id())
                        <div class="card-footer flex gap-2 mt-2">
                            <a href="{{ route('publication.edit', $publication->id) }}" class="btn-warning">Editar</a>
                            <form id="delete-form-{{ $publication->id }}"
                                action="{{ route('publication.destroy', ['publication' => $publication->id]) }}"
                                method="POST">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn-danger"
                                    onclick="confirmDelete({{ $publication->id }})">Excluir</button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <div class="alert-error">
                    Nenhum comentário encontrado
                </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $publications->links() }}
        </div>
    </div>
@endsection
