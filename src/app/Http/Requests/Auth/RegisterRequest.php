<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Data\Auth\RegisterUserData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

final class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => [
                'required',
                'string',
                Password::min(8)->letters()->numbers(),
            ],
            'passwordConfirmation' => ['required', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',
            'name.max' => 'O nome não pode ter mais de 120 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser um texto válido.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser um texto válido.',
            'passwordConfirmation.required' => 'A confirmação da senha é obrigatória.',
            'passwordConfirmation.same' => 'A confirmação da senha não corresponde à senha informada.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha',
            'passwordConfirmation' => 'confirmação da senha',
        ];
    }

    public function toData(): RegisterUserData
    {
        return new RegisterUserData(
            name: $this->string('name')->trim()->toString(),
            email: $this->string('email')->trim()->lower()->toString(),
            password: $this->string('password')->toString(),
        );
    }
}
