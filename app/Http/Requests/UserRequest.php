<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $user = $this->route('user');

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . ($user ? $user->id : null),
            'password' => 'required_if:password,!=,null|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório!',
            'email.required' => 'O e-mail é obrigatório!',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido!',
            'email.unique' => 'Este e-mail já está cadastrado!',
            'password.required_if' => 'A senha é obrigatória!',
            'password.min' => 'A senha deve ter no mínimo :min caracteres!',
        ];
    }
}
