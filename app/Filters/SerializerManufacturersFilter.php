<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Filters\Exceptions\InvalidFilterValueException;
use App\Filters\Traits\ContainsString;
use App\Filters\Traits\FilterCreated;
use App\Filters\Traits\FilterName;
use App\Filters\Traits\FilterUpdated;
use App\Models\SerializerManufacturer;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Filter<SerializerManufacturer>
 */
class SerializerManufacturersFilter extends Filter
{
    /**
     * @use ContainsString<SerializerManufacturer>
     * @use FilterName<SerializerManufacturer>
     * @use FilterCreated<SerializerManufacturer>
     * @use FilterUpdated<SerializerManufacturer>
     *
     * @throws InvalidFilterValueException
     */
    use ContainsString, FilterCreated, FilterName, FilterUpdated;

    /**
     * @param  array<string, ?string>  $filters
     */
    public function __construct(array $filters)
    {
        parent::__construct([
            'identifier' => FilterValueType::STRING,
            'name' => FilterValueType::STRING,
            'created_from' => FilterValueType::DATE,
            'created_to' => FilterValueType::DATE,
            'updated_from' => FilterValueType::DATE,
            'updated_to' => FilterValueType::DATE,
        ], $filters);
    }

    /**
     * @param  Builder<SerializerManufacturer>  $query
     * @return Builder<SerializerManufacturer>
     */
    protected function filterIdentifier(Builder $query, string $value): Builder
    {
        return $this->columnContainsString($query, 'id', $value);
    }
}
