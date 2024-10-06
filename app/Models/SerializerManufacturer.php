<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
