<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'total_amount' => ['sometimes', 'numeric', 'min:0.01', 'max:999999.99'],
            'month'        => ['sometimes', 'date_format:Y-m-d'],
            'is_recurring' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'total_amount.numeric'  => 'El importe debe ser un número.',
            'total_amount.min'      => 'El importe debe ser mayor que 0.',
            'total_amount.max'      => 'El importe no puede superar 999.999,99€.',
            'month.date_format'     => 'El mes debe tener el formato YYYY-MM-DD.',
            'is_recurring.boolean'  => 'El campo recurrente debe ser verdadero o falso.',
        ];
    }
}
