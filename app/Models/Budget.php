<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'month',
        'is_recurring',
    ];

    protected function casts(): array
    {
        return [
            'is_recurring' => 'boolean',
            'month'        => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
}
