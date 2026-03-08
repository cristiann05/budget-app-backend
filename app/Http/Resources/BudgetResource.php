<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'total_amount' => $this->total_amount,
            'month'        => $this->month->format('Y-m-d'),
            'is_recurring' => $this->is_recurring,
            'allocations'  => AllocationResource::collection($this->whenLoaded('allocations')),
        ];
    }
}
