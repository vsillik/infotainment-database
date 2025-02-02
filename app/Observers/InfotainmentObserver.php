<?php

namespace App\Observers;

use App\Models\Infotainment;
use Illuminate\Support\Facades\Auth;

class InfotainmentObserver
{
    public function creating(Infotainment $infotainment): void
    {
        if (Auth::check()) {
            $infotainment->createdBy()->associate(Auth::user());
        }
    }

    public function updating(Infotainment $infotainment): void
    {
        if (Auth::check()) {
            $infotainment->updatedBy()->associate(Auth::user());
        }
    }
}
