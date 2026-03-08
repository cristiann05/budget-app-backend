<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email', 'unique:users,email', 'different:' . $this->user()->email],
            'password' => ['required', 'string', 'current_password'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'El email es obligatorio.',
            'email.email'       => 'El email no tiene un formato válido.',
            'email.unique'      => 'Este email ya está en uso.',
            'email.different'   => 'El nuevo email debe ser diferente al actual.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.current_password' => 'La contraseña no es correcta.',
        ];
    }
}
