<?php

namespace App\Observers;

use App\Models\SerializerManufacturer;
use Illuminate\Support\Facades\Auth;

class SerializerManufacturerObserver
{
    public function creating(SerializerManufacturer $serializerManufacturer): void
    {
        if (Auth::check()) {
            $serializerManufacturer->createdBy()->associate(Auth::user());
            $serializerManufacturer->updatedBy()->associate(Auth::user());
        }
    }

    public function updating(SerializerManufacturer $serializerManufacturer): void
    {
        if (Auth::check()) {
            $serializerManufacturer->updatedBy()->associate(Auth::user());
        }
    }
}
