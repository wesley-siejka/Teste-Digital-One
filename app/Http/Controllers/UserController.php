<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Publication;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->input('filtro', 'todos'); // 'todos' ou 'meus'
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

    public function show(User $user)
    {
        //dd($user); teste para ver se esta puxando os registros do banco
        //carregar a view
        return view('user.show', ['user' => $user]);
    }

    // carrega o formulario de cadastrar novo usuario
    public function create()
    {
        return view('user.create');
    }

    //cadatrar no banco de dados novo registro
    public function store(UserRequest $request)
    {
        // dd($request);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {

            return back()->withInput()->with('error', 'Erro ao cadastrar usuário!');
        }
    }

    // carregar o formulario de editar usuario
    public function edit(User $user)
    {
        //carregar a view
        return view('user.edit', ['user' => $user]);
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            //Editar as informações do registro do banco dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            //redirecionar com mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
        } catch (Exception $e) {
            //redirecionar com mensagem de erro
            return back()->withInput()->with('error', 'Erro ao editar usuário!');
        }
    }

    //chama a tela de edição de senha
    public function editPassword(User $user)
    {
        //carregar a view
        return view('user.editPassword', ['user' => $user]);
    }


    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Digite sua senha atual.',
            'password.required' => 'Digite a nova senha.',
            'password.min' => 'A nova senha deve ter no mínimo :min caracteres.',
            'password.confirmed' => 'A confirmação da nova senha não confere.',
        ]);

        // Verifica se a senha atual está correta
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withInput()->with('error', 'Senha atual incorreta!');
        }

        try {
            $user->update([
                'password' => $request->password,
            ]);
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Senha alterada com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao alterar senha!');
        }
    }

    public function destroy(User $user)
    {
        try {

            //excluir o registro do banco de dados
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Usuário excluído com sucesso!');
        } catch (Exception $e) {

            //redirecionar com mensagem de erro
            return redirect()->route('user.index')->with('error', 'Erro ao excluir usuário!');
        }
    }
}
