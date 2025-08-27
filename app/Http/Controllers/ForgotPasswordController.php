<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // formulario para receber o link recuperar senha
    public function showLinkRequestForm()
    {
        //carrega a view
        return view('auth.forgot_password');
    }

    //receber dados do formulario recuperar senha
    public function sendResetLinkEmail(Request $request)
    {
        //validar o formulario
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email' => 'O e-mail informado não é válido.',
        ]);

        //verificar se existe usuario no banco de dados com o e-mail
        $user = User::where('email', $request->email)->first();

        //verificar se encontrou o usuario
        if (!$user) {

            //redirecionar o usuario com mensagem de erro
            return back()->withInput()->with('error', 'E-mail não encontrado!');
        }

        try {
            //salvar o token recuperar senha e enviar e-mail
            $status = Password::sendResetLink(
                //retorna um array associativo contendo apenas o campo "email" da requisição.
                $request->only('email')
            );

            //redireciona o usuario, mensagem de sucesso
            return redirect()->route('login')->with('success', 'Eviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!');
        } catch (Exception $e){

            //redireciona o usuario, mensagem de erro
            return back()->withInput()->with('error', 'Tente novamente mais tarde.');
        }
    }

    public function showRequestForm(Request $request)
    {
        try {
            //recuperar os dados do usuario no banco de dados atraves do e-mail
            $user = User::where('email', $request->email)->first();

            //verificar se encontrou o usuario no BD e o token é valido
            if (!$user || !Password::tokenExists($user, $request->token)) {
                //redirecionar o usuario, enviar a mensagem de erro
                return redirect()->route('login')->with('error', 'Token inválido ou expirado!');
            }

            //carregar a view para redefinir a senha
            return view('auth.reset_password', ['token' => $request->token, 'email' => $request->email]);
        } catch (Exception $e) {
            //redirecionar o usuario, enviar a mensagem de erro
            return redirect()->route('login')->with('error', 'Token inválido ou expirado!');

        }
    }

    public function reset(Request $request)
    {
        //validar o formulario
        $request->validate(
            [
                'email' => 'required|email|exists:users',
                'password' => 'required|min:6|confirmed',
            ],
            [
                'password.required' => 'O campo de senha é obrigatório.',
                'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
                'password.confirmed' => 'As senhas não conferem.',
            ]
        );

        try {
            //reset - redefinir a senha do usuario
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),

                function(User $user,string $password) {
                    //forceFill - Forçar o acesso a atributos protegidos
                    $user->forceFill([
                        'password' => $password
                    ]);

                    //salva as alterações
                    $user->save();
                }
            );

            //redirecionar o usuario, mensagem de sucesso ou de erro 
            return $status === Password::PASSWORD_RESET ? redirect()->route('login')->with('success', 'Senha redefinida com sucesso!') : redirect()->route('login')->with('error', 'Erro ao redefinir a senha, tente novamente.');
        } catch (Exception $e) {

            //redirecionar o usuario, mensagem de erro
            return back()->withInput()->with('error', 'Erro ao redefinir a senha, tente novamente.');
        }
    }
}
