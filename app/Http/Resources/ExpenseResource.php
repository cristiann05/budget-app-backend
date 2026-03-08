<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'allocation_id' => $this->allocation_id,
            'description'   => $this->description,
            'amount'        => $this->amount,
            'date'          => $this->date->format('Y-m-d'),
        ];
    }
}
