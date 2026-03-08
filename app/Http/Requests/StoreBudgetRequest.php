<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'total_amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'month'        => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'is_recurring' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'total_amount.required'    => 'El importe total es obligatorio.',
            'total_amount.numeric'     => 'El importe debe ser un número.',
            'total_amount.min'         => 'El importe debe ser mayor que 0.',
            'total_amount.max'         => 'El importe no puede superar 999.999,99€.',
            'month.required'           => 'El mes del presupuesto es obligatorio.',
            'month.date_format'        => 'El mes debe tener el formato YYYY-MM-DD.',
            'month.after_or_equal'     => 'No puedes crear un presupuesto en el pasado.',
            'is_recurring.boolean'     => 'El campo recurrente debe ser verdadero o falso.',
        ];
    }
}
