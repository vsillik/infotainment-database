<?php

namespace App\Policies;

use App\Models\User;
use App\UserRole;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->value >= UserRole::ADMINISTRATOR->value;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->value >= UserRole::ADMINISTRATOR->value;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $this->create($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $this->create($user);
    }

    public function approve(User $user, User $model): bool
    {
        return $this->create($user);
    }

    public function unapprove(User $user, User $model): bool
    {
        return $this->approve($user, $model);
    }

    public function assignInfotainments(User $user, User $model): bool
    {
        return $this->approve($user, $model);
    }

}
