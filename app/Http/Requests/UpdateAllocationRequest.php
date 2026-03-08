<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAllocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['sometimes', 'exists:categories,id'],
            'amount'      => ['sometimes', 'numeric', 'min:0.01', 'max:999999.99'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'amount.numeric'     => 'El importe debe ser un número.',
            'amount.min'         => 'El importe debe ser mayor que 0.',
            'amount.max'         => 'El importe no puede superar 999.999,99€.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $budget = $this->route('budget');
            $allocation = $this->route('allocation');

            if (!$budget || !$allocation) return;

            $totalAsignado = $budget->allocations()->where('id', '!=', $allocation->id)->sum('amount');
            $nuevo = $this->amount ?? $allocation->amount;

            if (($totalAsignado + $nuevo) > $budget->total_amount) {
                $validator->errors()->add(
                    'amount',
                    'El importe supera el presupuesto disponible. Disponible: ' . ($budget->total_amount - $totalAsignado) . '€'
                );
            }
        });
    }
}
