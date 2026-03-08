<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => ['sometimes', 'string', 'max:150'],
            'amount'      => ['sometimes', 'numeric', 'min:0.01', 'max:999999.99'],
            'date'        => ['sometimes', 'date_format:Y-m-d', 'before_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'description.max'      => 'La descripción no puede superar los 150 caracteres.',
            'amount.numeric'       => 'El importe debe ser un número.',
            'amount.min'           => 'El importe debe ser mayor que 0.',
            'amount.max'           => 'El importe no puede superar 999.999,99€.',
            'date.date_format'     => 'La fecha debe tener el formato YYYY-MM-DD.',
            'date.before_or_equal' => 'No puedes registrar un gasto en el futuro.',
        ];
    }
}
