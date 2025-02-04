<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function deleting(User $user): void
    {
        $user->is_approved = false;

        if (Auth::check()) {
            $user->deletedBy()->associate(Auth::user());
        }

        $user->save();
    }

    public function restoring(User $user): void
    {
        $user->deletedBy()->disassociate();
    }
}
