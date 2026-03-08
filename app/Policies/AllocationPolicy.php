<?php

namespace App\Policies;

use App\Models\Allocation;
use App\Models\User;

class AllocationPolicy
{
    public function viewAny(User $user, $budget): bool
    {
        return $user->id === $budget->user_id;
    }

    public function view(User $user, Allocation $allocation): bool
    {
        return $user->id === $allocation->budget->user_id;
    }

    public function create(User $user, $budget): bool
    {
        return $user->id === $budget->user_id;
    }

    public function update(User $user, Allocation $allocation): bool
    {
        return $user->id === $allocation->budget->user_id;
    }

    public function delete(User $user, Allocation $allocation): bool
    {
        return $user->id === $allocation->budget->user_id;
    }
}
