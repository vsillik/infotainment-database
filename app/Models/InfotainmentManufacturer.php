<?php

namespace App\Models;

use App\Observers\InfotainmentManufacturerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @mixin Builder<InfotainmentManufacturer>
 *
 * @property int $id
 * @property string $name
 * @property ?string $internal_notes
 * @property Collection<int, Infotainment> $infotainments
 * @property ?User $createdBy
 * @property ?User $updatedBy
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
#[ObservedBy([InfotainmentManufacturerObserver::class])]
class InfotainmentManufacturer extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * @return HasMany<Infotainment, $this>
     */
    public function infotainments(): HasMany
    {
        return $this->hasMany(Infotainment::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
