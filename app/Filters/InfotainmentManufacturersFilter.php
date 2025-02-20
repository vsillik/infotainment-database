<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Filters\Traits\FilterCreatedAt;
use App\Filters\Traits\FilterName;
use App\Filters\Traits\FilterUpdatedAt;
use App\Models\InfotainmentManufacturer;

/**
 * @extends Filter<InfotainmentManufacturer>
 */
class InfotainmentManufacturersFilter extends Filter
{
    /**
     * @use FilterCreatedAt<InfotainmentManufacturer>
     * @use FilterName<InfotainmentManufacturer>
     * @use FilterUpdatedAt<InfotainmentManufacturer>
     */
    use FilterCreatedAt, FilterName, FilterUpdatedAt;

    /**
     * @param  array<string, ?string>  $filters
     */
    public function __construct(array $filters)
    {
        parent::__construct([
            'name' => FilterValueType::STRING,
            'created_at' => FilterValueType::DATE,
            'updated_at' => FilterValueType::DATE,
        ], $filters);
    }
}
