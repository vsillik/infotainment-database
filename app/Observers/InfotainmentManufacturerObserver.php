<?php

namespace App\Observers;

use App\Models\InfotainmentManufacturer;
use Illuminate\Support\Facades\Auth;

class InfotainmentManufacturerObserver
{
    public function creating(InfotainmentManufacturer $infotainmentManufacturer): void
    {
        if (Auth::check()) {
            $infotainmentManufacturer->createdBy()->associate(Auth::user());
            $infotainmentManufacturer->updatedBy()->associate(Auth::user());
        }
    }

    public function updating(InfotainmentManufacturer $infotainmentManufacturer): void
    {
        if (Auth::check()) {
            $infotainmentManufacturer->updatedBy()->associate(Auth::user());
        }
    }
}
