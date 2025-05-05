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
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @mixin Builder<Infotainment>
 *
 * @property int $id
 * @property int $infotainment_manufacturer_id
 * @property string $serializer_manufacturer_id
 * @property string $product_id
 * @property int $model_year
 * @property string $part_number
 * @property ?string $compatible_platforms
 * @property ?string $internal_code
 * @property ?string $internal_notes
 * @property InfotainmentManufacturer $infotainmentManufacturer
 * @property SerializerManufacturer $serializerManufacturer
 * @property Collection<int, InfotainmentProfile> $profiles
 * @property Collection<int, User> $users
 * @property ?User $createdBy
 * @property ?User $updatedBy
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
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

    /**
     * @return BelongsTo<InfotainmentManufacturer, $this>
     */
    public function infotainmentManufacturer(): BelongsTo
    {
        return $this->belongsTo(InfotainmentManufacturer::class);
    }

    /**
     * @return BelongsTo<SerializerManufacturer, $this>
     */
    public function serializerManufacturer(): BelongsTo
    {
        return $this->belongsTo(SerializerManufacturer::class);
    }

    /**
     * Returns the latest approved profile or unapproved profile if there are no approved profiles
     *
     * @return HasOne<InfotainmentProfile, $this>
     */
    public function latestProfile(): HasOne
    {
        return $this->hasOne(InfotainmentProfile::class)
            ->orderByDesc('is_approved') // first take in consideration approved profiles
            ->orderByDesc('updated_at') // then order by updated timestamps
            ->latest('updated_at'); // limit to only one profile
    }

    /**
     * @return HasMany<InfotainmentProfile, $this>
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(InfotainmentProfile::class);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
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
