<?php

namespace App\Policies;

use App\Models\InfotainmentManufacturer;
use App\Models\User;
use App\UserRole;

class InfotainmentManufacturerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->value >= UserRole::OPERATOR->value;
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
    public function update(User $user, InfotainmentManufacturer $infotainmentManufacturer): bool
    {
        return $this->create($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InfotainmentManufacturer $infotainmentManufacturer): bool
    {
        return $user->role->value >= UserRole::ADMINISTRATOR->value;
    }
}
