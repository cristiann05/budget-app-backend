<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:50'],
            'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'El nombre de la categoría es obligatorio.',
            'name.max'       => 'El nombre no puede superar los 50 caracteres.',
            'color.required' => 'El color es obligatorio.',
            'color.regex'    => 'El color debe ser un código hexadecimal válido, ejemplo: #f0b840.',
        ];
    }
}
