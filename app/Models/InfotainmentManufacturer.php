<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property string name
 * @property Collection<int, Infotainment> $infotainments
 */
class InfotainmentManufacturer extends Model
{

    protected $fillable = [
        'name',
    ];

    public function infotainments(): HasMany
    {
        return $this->hasMany(Infotainment::class);
    }
}
