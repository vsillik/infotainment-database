<?php

namespace App\Observers;

use App\Models\InfotainmentProfile;
use Illuminate\Support\Facades\Auth;

class InfotainmentProfileObserver
{
    public function creating(InfotainmentProfile $infotainmentProfile): void
    {
        if (Auth::check()) {
            $infotainmentProfile->createdBy()->associate(Auth::user());
        }
    }

    public function updating(InfotainmentProfile $infotainmentProfile): void
    {
        if (Auth::check()) {
            $infotainmentProfile->updatedBy()->associate(Auth::user());
        }
    }

}
