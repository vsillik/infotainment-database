<?php

namespace App\Models;

use App\Observers\InfotainmentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Builder
 *
 * @property int $id
 * @property int $infotainment_manufacturer_id
 * @property string $serializer_manufacturer_id
 * @property string $product_id
 * @property int $model_year
 * @property string $part_number
 * @property string $compatible_platforms
 * @property string $internal_code
 * @property string $internal_notes
 * @property InfotainmentManufacturer $infotainmentManufacturer
 * @property SerializerManufacturer $serializerManufacturer
 * @property Collection<int, InfotainmentProfile> $profiles
 * @property Collection<int, User> $users
 * @property ?User $createdBy
 * @property ?User $updatedBy
 */
#[ObservedBy([InfotainmentObserver::class])]
class Infotainment extends Model
{
    protected $fillable = [
        'infotainment_manufacturer_id',
        'serializer_manufacturer_id',
        'model_year',
        'part_number',
        'compatible_platforms',
        'internal_code',
        'internal_notes',
    ];

    public function infotainmentManufacturer(): BelongsTo
    {
        return $this->belongsTo(InfotainmentManufacturer::class);
    }

    public function serializerManufacturer(): BelongsTo
    {
        return $this->belongsTo(SerializerManufacturer::class);
    }

    public function profiles(): HasMany
    {
        return $this->hasMany(InfotainmentProfile::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
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
