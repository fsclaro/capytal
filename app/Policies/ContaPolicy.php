<?php

namespace App\Policies;

use App\Models\Conta;
use App\Models\User;

class ContaPolicy
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
    public function view(User $user, Conta $conta): bool
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
    public function update(User $user, Conta $conta): bool
    {
        return $user->isActive() && auth()->check();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Conta $conta): bool
    {
        return $user->isActive() && auth()->check();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Conta $conta): bool
    {
        return $user->isActive() && auth()->check();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Conta $conta): bool
    {
        return $user->isActive() && auth()->check();
    }
}
