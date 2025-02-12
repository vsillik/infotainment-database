<?php

namespace App\Models;

use App\Observers\UserObserver;
use App\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin Builder<User>
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property UserRole $role
 * @property bool $is_approved
 * @property ?string $remember_token
 * @property ?User $deletedBy
 * @property Collection<int, Infotainment> $infotainments
 * @property Collection<int, InfotainmentManufacturer> $createdInfotainmentManufacturers
 * @property Collection<int, InfotainmentManufacturer> $updatedInfotainmentManufacturers
 * @property Collection<string, SerializerManufacturer> $createdSerializerManufacturers
 * @property Collection<string, SerializerManufacturer> $updatedSerializerManufacturers
 * @property Collection<int, Infotainment> $createdInfotainments
 * @property Collection<int, Infotainment> $updatedInfotainments
 * @property Collection<int, InfotainmentProfile> $createdInfotainmentProfiles
 * @property Collection<int, InfotainmentProfile> $updatedInfotainmentProfiles
 * @property Collection<int, User> $deletedUsers
 */
#[ObservedBy(UserObserver::class)]
class User extends Authenticatable
{
    /**
     * @use HasFactory<UserFactory>
     */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => UserRole::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return BelongsToMany<Infotainment, $this>
     */
    public function infotainments(): BelongsToMany
    {
        return $this->belongsToMany(Infotainment::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * @return HasMany<InfotainmentManufacturer, $this>
     */
    public function createdInfotainmentManufacturers(): HasMany
    {
        return $this->hasMany(InfotainmentManufacturer::class, 'created_by');
    }

    /**
     * @return HasMany<InfotainmentManufacturer, $this>
     */
    public function updatedInfotainmentManufacturers(): HasMany
    {
        return $this->hasMany(InfotainmentManufacturer::class, 'updated_by');
    }

    /**
     * @return HasMany<SerializerManufacturer, $this>
     */
    public function createdSerializerManufacturers(): HasMany
    {
        return $this->hasMany(SerializerManufacturer::class, 'created_by');
    }

    /**
     * @return HasMany<InfotainmentManufacturer, $this>
     */
    public function updatedSerializerManufacturers(): HasMany
    {
        return $this->hasMany(InfotainmentManufacturer::class, 'updated_by');
    }

    /**
     * @return HasMany<Infotainment, $this>
     */
    public function createdInfotainments(): HasMany
    {
        return $this->hasMany(Infotainment::class, 'created_by');
    }

    /**
     * @return HasMany<Infotainment, $this>
     */
    public function updatedInfotainments(): HasMany
    {
        return $this->hasMany(Infotainment::class, 'updated_by');
    }

    /**
     * @return HasMany<InfotainmentProfile, $this>
     */
    public function createdInfotainmentProfiles(): HasMany
    {
        return $this->hasMany(InfotainmentProfile::class, 'created_by');
    }

    /**
     * @return HasMany<InfotainmentProfile, $this>
     */
    public function updatedInfotainmentProfiles(): HasMany
    {
        return $this->hasMany(InfotainmentProfile::class, 'updated_by');
    }

    /**
     * @return HasMany<User, $this>
     */
    public function deletedUsers(): HasMany
    {
        return $this->hasMany(User::class, 'deleted_by');
    }
}
