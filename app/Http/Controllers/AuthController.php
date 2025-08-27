<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {   

        //carrega a view de login
        return view('auth.login');
    }

    public function loginProcess(AuthLoginRequest $request)
    {
        //capturar possiveis exceções durante a execução
        try {
            // validar o usuario e a senha com informações do banco de dados
            $authenticated = Auth::attempt
            ([
                'email' => $request->email, 
                'password' => $request->password
            ]);

            //verificar se foi autenticado
            if(!$authenticated) {
                return back()->withInput()->with('error', 'email ou senha invalido!');
            }

            //redirecionar o usuario
            return redirect()->route('user.index');

        } catch (\Exception $e) {
            //redirecionar com mensagem de erro
            return back()->withInput()->with('error', 'email ou senha invalido!');
        }
    }

    //deslogar o usuario
    public function logout()
    {
        //deslogar o usuario
        Auth::logout();

        //redirecionar para tela de login
        return redirect()->route('login')->with('success', 'Deslogado com sucesso!');
    }
}
