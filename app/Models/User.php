<?php

namespace App\Models;

use App\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property UserRole $role
 * @property bool $is_approved
 * @property Collection<int, Infotainment> $infotainments
 * @property Collection<int, InfotainmentManufacturer> $createdInfotainmentManufacturers
 * @property Collection<int, InfotainmentManufacturer> $updatedInfotainmentManufacturers
 * @property Collection<string, SerializerManufacturer> $createdSerializerManufacturers
 * @property Collection<string, SerializerManufacturer> $updatedSerializerManufacturers
 * @property Collection<int, Infotainment> $createdInfotainments
 * @property Collection<int, Infotainment> $updatedInfotainments
 * @property Collection<int, InfotainmentProfile> $createdInfotainmentProfiles
 * @property Collection<int, InfotainmentProfile> $updatedInfotainmentProfiles
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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

    public function infotainments(): BelongsToMany
    {
        return $this->belongsToMany(Infotainment::class);
    }

    public function createdInfotainmentManufacturers(): HasMany
    {
        return $this->hasMany(InfotainmentManufacturer::class, 'created_by');
    }

    public function updatedInfotainmentManufacturers(): HasMany
    {
        return $this->hasMany(InfotainmentManufacturer::class, 'updated_by');
    }

    public function createdSerializerManufacturers(): HasMany
    {
        return $this->hasMany(SerializerManufacturer::class, 'created_by');
    }

    public function updatedSerializerManufacturers(): HasMany
    {
        return $this->hasMany(InfotainmentManufacturer::class, 'updated_by');
    }

    public function createdInfotainments(): HasMany
    {
        return $this->hasMany(Infotainment::class, 'created_by');
    }

    public function updatedInfotainments(): HasMany
    {
        return $this->hasMany(Infotainment::class, 'updated_by');
    }

    public function createdInfotainmentProfiles(): HasMany
    {
        return $this->hasMany(InfotainmentProfile::class, 'created_by');
    }

    public function updatedInfotainmentProfiles(): HasMany
    {
        return $this->hasMany(InfotainmentProfile::class, 'updated_by');
    }
}
