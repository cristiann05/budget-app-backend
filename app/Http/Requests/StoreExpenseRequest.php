<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:150'],
            'amount'      => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'date'        => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'description.required'  => 'La descripción es obligatoria.',
            'description.max'       => 'La descripción no puede superar los 150 caracteres.',
            'amount.required'       => 'El importe es obligatorio.',
            'amount.numeric'        => 'El importe debe ser un número.',
            'amount.min'            => 'El importe debe ser mayor que 0.',
            'amount.max'            => 'El importe no puede superar 999.999,99€.',
            'date.required'         => 'La fecha es obligatoria.',
            'date.date_format'      => 'La fecha debe tener el formato YYYY-MM-DD.',
            'date.before_or_equal'  => 'No puedes registrar un gasto en el futuro.',
        ];
    }
}
