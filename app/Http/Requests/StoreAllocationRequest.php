<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAllocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'amount'      => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists'   => 'La categoría seleccionada no existe.',
            'amount.required'      => 'El importe es obligatorio.',
            'amount.numeric'       => 'El importe debe ser un número.',
            'amount.min'           => 'El importe debe ser mayor que 0.',
            'amount.max'           => 'El importe no puede superar 999.999,99€.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $budget = $this->route('budget');

            if (!$budget) return;

            $totalAsignado = $budget->allocations()->sum('amount');
            $nuevo = $this->amount;

            if (($totalAsignado + $nuevo) > $budget->total_amount) {
                $validator->errors()->add(
                    'amount',
                    'El importe supera el presupuesto disponible. Disponible: ' . ($budget->total_amount - $totalAsignado) . '€'
                );
            }
        });
    }
}
