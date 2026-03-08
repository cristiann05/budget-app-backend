<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 1; // Solo Admin
    }

    public function view(User $user, User $model): bool
    {
        return $user->role === 1 // Admin ve cualquiera
            || $user->id === $model->id; // Usuario ve el suyo
    }

    public function update(User $user, User $model): bool
    {
        return $user->role === 1 // Admin actualiza cualquiera
            || $user->id === $model->id; // Usuario actualiza el suyo
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role === 1; // Solo Admin
    }
}
