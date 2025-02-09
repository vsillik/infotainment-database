<?php

namespace App\Models;

use App\Observers\InfotainmentManufacturerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @mixin Builder
 * @property int id
 * @property string name
 * @property Collection<int, Infotainment> $infotainments
 * @property ?User $createdBy
 * @property ?User $updatedBy
 */
#[ObservedBy([InfotainmentManufacturerObserver::class])]
class InfotainmentManufacturer extends Model
{
    protected $fillable = [
        'name',
    ];

    public function infotainments(): HasMany
    {
        return $this->hasMany(Infotainment::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
