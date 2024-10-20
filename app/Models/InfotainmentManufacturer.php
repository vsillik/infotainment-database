<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property string name
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
