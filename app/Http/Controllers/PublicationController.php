<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicationController extends Controller
{
    // Lista publicações com filtro
    public function index(Request $request)
    {
        $filtro = $request->input('filtro', 'todos');
        $pesquisar = $request->input('pesquisar');


        $query = Publication::query();

        if ($filtro === 'meus') {
            $query->where('user_id', Auth::id());
        } else {
            $query->where(function ($q) {
                $q->where('status', 'public')
                    ->orWhere('user_id', Auth::id());
            });
        }

        if ($pesquisar) {
            $query->where(function ($q) use ($pesquisar) {
                $q->where('title', 'like', "%{$pesquisar}%")
                    ->orWhere('content', 'like', "%{$pesquisar}%")
                    ->orWhereHas('user', function ($qu) use ($pesquisar) {
                        $qu->where('name', 'like', "%{$pesquisar}%")
                            ->orWhere('email', 'like', "%{$pesquisar}%");
                    });
            });
        }

        $publications = $query->orderBy('created_at', 'desc')->paginate(6)->withQueryString();

        return view('publication.index', [
            'publications' => $publications,
            'pesquisar' => $pesquisar,
            'filtro' => $filtro,
        ]);
    }

    // Exibe o formulário de criação
    public function create()
    {
        return view('publication.create');
    }

    // Salva nova publicação
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:public,private',
        ], [
            'title.required' => 'O título é obrigatório.',
            'content.required' => 'O conteúdo é obrigatório.',
            'status.required' => 'O status é obrigatório.',
        ]);

        Publication::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect()->route('user.index')->with('success', 'Comentário criado com sucesso!');
    }

    // Exibe o formulário de edição
    public function edit(Publication $publication)
    {
        // Permite editar apenas se for o autor
        if ($publication->user_id !== Auth::id()) {
            return redirect()->route('publication.index')->with('error', 'Acesso negado!');
        }
        return view('publication.edit', compact('publication'));
    }

    // Atualiza publicação
    public function update(Request $request, Publication $publication)
    {
        if ($publication->user_id !== Auth::id()) {
            return redirect()->route('publication.index')->with('error', 'Acesso negado!');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:public,private',
        ]);

        $publication->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect()->route('publication.index')->with('success', 'Comentário atualizado!');
    }

    // Exclui publicação
    public function destroy(Publication $publication)
    {
        if ($publication->user_id !== Auth::id()) {
            return redirect()->route('publication.index')->with('error', 'Acesso negado!');
        }

        $publication->delete();

        return redirect()->route('publication.index')->with('success', 'Comentário excluído!');
    }
}
