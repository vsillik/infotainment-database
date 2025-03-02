<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\SerializerManufacturer;
use App\Models\User;

class SerializerManufacturerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->value >= UserRole::OPERATOR->value;
    }

    public function view(User $user, SerializerManufacturer $serializerManufacturer): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->role->value >= UserRole::OPERATOR->value;
    }

    public function update(User $user, SerializerManufacturer $serializerManufacturer): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, SerializerManufacturer $serializerManufacturer): bool
    {
        return $user->role->value >= UserRole::ADMINISTRATOR->value;
    }
}
