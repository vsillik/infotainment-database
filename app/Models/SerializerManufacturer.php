<?php

namespace App\Models;

use App\Observers\SerializerManufacturerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string id
 * @property string name
 * @property Collection<int, Infotainment> $infotainments
 * @property ?User $createdBy
 * @property ?User $updatedBy
 */
#[ObservedBy([SerializerManufacturerObserver::class])]
class SerializerManufacturer extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
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
