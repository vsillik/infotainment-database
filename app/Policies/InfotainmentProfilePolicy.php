<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\InfotainmentProfile;
use App\Models\User;

class InfotainmentProfilePolicy
{
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
    public function update(User $user, InfotainmentProfile $infotainmentProfile): bool
    {
        return $this->create($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InfotainmentProfile $infotainmentProfile): bool
    {
        return $user->role->value >= UserRole::ADMINISTRATOR->value;
    }

    public function approve(User $user, InfotainmentProfile $infotainmentProfile): bool
    {
        return $user->role->value >= UserRole::VALIDATOR->value;
    }
}
