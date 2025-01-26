<?php

namespace App\Policies;

use App\Models\Infotainment;
use App\Models\User;
use App\UserRole;

class InfotainmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->value >= UserRole::CUSTOMER->value;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Infotainment $infotainment): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->value >= UserRole::OPERATOR->value;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Infotainment $infotainment): bool
    {
        return $this->create($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Infotainment $infotainment): bool
    {
        return $user->role->value >= UserRole::ADMINISTRATOR->value;
    }

    public function assignUsers(User $user): bool
    {
        return $user->role->value >= UserRole::ADMINISTRATOR->value;
    }

}
