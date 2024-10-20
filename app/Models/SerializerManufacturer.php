<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string id
 * @property string name
 */
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
}
