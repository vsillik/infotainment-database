<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\InfotainmentManufacturer;
use App\Models\User;

class InfotainmentManufacturerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->value >= UserRole::OPERATOR->value;
    }

    public function view(User $user, InfotainmentManufacturer $infotainmentManufacturer): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->role->value >= UserRole::OPERATOR->value;
    }

    public function update(User $user, InfotainmentManufacturer $infotainmentManufacturer): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, InfotainmentManufacturer $infotainmentManufacturer): bool
    {
        return $user->role->value >= UserRole::ADMINISTRATOR->value;
    }
}
