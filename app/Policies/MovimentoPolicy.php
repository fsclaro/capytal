<?php

namespace App\Policies;

use App\Models\Movimento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MovimentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isActive() && auth()->check();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Movimento $movimento): bool
    {
        return $user->isActive() && auth()->check();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isActive() && auth()->check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Movimento $movimento): bool
    {
        return $user->isActive() && auth()->check();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Movimento $movimento): bool
    {
        return $user->isActive() && auth()->check();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Movimento $movimento): bool
    {
        return $user->isActive() && auth()->check();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Movimento $movimento): bool
    {
        return $user->isActive() && auth()->check();
    }
}
