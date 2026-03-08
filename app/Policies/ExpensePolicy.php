<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;

class ExpensePolicy
{
    public function viewAny(User $user, $allocation): bool
    {
        return $user->id === $allocation->budget->user_id;
    }

    public function view(User $user, Expense $expense): bool
    {
        return $user->id === $expense->allocation->budget->user_id;
    }

    public function create(User $user, $allocation): bool
    {
        return $user->id === $allocation->budget->user_id;
    }

    public function update(User $user, Expense $expense): bool
    {
        return $user->id === $expense->allocation->budget->user_id;
    }

    public function delete(User $user, Expense $expense): bool
    {
        return $user->id === $expense->allocation->budget->user_id;
    }
}
