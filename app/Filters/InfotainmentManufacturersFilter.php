<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Filters\Exceptions\InvalidFilterValueException;
use App\Filters\Traits\FilterCreated;
use App\Filters\Traits\FilterName;
use App\Filters\Traits\FilterUpdated;
use App\Models\InfotainmentManufacturer;

/**
 * @extends Filter<InfotainmentManufacturer>
 */
class InfotainmentManufacturersFilter extends Filter
{
    /**
     * @use FilterCreated<InfotainmentManufacturer>
     * @use FilterName<InfotainmentManufacturer>
     * @use FilterUpdated<InfotainmentManufacturer>
     *
     * @throws InvalidFilterValueException
     */
    use FilterCreated, FilterName, FilterUpdated;

    /**
     * @param  array<string, ?string>  $filters
     */
    public function __construct(array $filters)
    {
        parent::__construct([
            'name' => FilterValueType::STRING,
            'created_from' => FilterValueType::DATE,
            'created_to' => FilterValueType::DATE,
            'updated_from' => FilterValueType::DATE,
            'updated_to' => FilterValueType::DATE,
        ], $filters);
    }
}
