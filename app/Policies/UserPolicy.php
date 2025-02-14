<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->value >= UserRole::ADMINISTRATOR->value;
    }

    public function view(User $user, User $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->role->value >= UserRole::ADMINISTRATOR->value;
    }

    public function update(User $user, User $model): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, User $model): bool
    {
        // don't allow to delete default admin user
        if ($model->id === 1) {
            return false;
        }

        return $this->create($user);
    }

    public function forceDelete(User $user, User $model): bool
    {
        // we can't delete the user because of integrity restrictions
        // if the user created or made last change to some entities
        if ($model->createdInfotainmentManufacturers->count() > 0 ||
            $model->updatedInfotainmentManufacturers->count() > 0 ||
            $model->createdSerializerManufacturers->count() > 0 ||
            $model->updatedSerializerManufacturers->count() > 0 ||
            $model->createdInfotainments->count() > 0 ||
            $model->updatedInfotainments->count() > 0 ||
            $model->createdInfotainmentProfiles->count() > 0 ||
            $model->updatedInfotainmentProfiles->count() > 0) {
            return false;
        }

        return $this->delete($user, $model);
    }

    public function restore(User $user, User $model): bool
    {
        return $this->create($user);
    }

    public function approve(User $user, User $model): bool
    {
        return $this->create($user);
    }

    public function unapprove(User $user, User $model): bool
    {
        // don't allow to unapprove default admin user
        if ($model->id === 1) {
            return false;
        }

        return $this->approve($user, $model);
    }

    public function assignInfotainments(User $user, User $model): bool
    {
        return $this->approve($user, $model);
    }
}
