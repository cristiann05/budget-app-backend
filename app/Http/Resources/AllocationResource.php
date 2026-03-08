<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'budget_id'   => $this->budget_id,
            'category'    => new CategoryResource($this->whenLoaded('category')),
            'amount'      => $this->amount,
            'expenses'    => ExpenseResource::collection($this->whenLoaded('expenses')),
        ];
    }
}
