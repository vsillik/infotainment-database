<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Filters\Traits\ContainsString;
use App\Filters\Traits\FilterCreatedAt;
use App\Filters\Traits\FilterName;
use App\Filters\Traits\FilterUpdatedAt;
use App\Models\SerializerManufacturer;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Filter<SerializerManufacturer>
 */
final class SerializerManufacturersFilter extends Filter
{
    /**
     * @use ContainsString<SerializerManufacturer>
     * @use FilterName<SerializerManufacturer>
     * @use FilterCreatedAt<SerializerManufacturer>
     * @use FilterUpdatedAt<SerializerManufacturer>
     */
    use ContainsString, FilterCreatedAt, FilterName, FilterUpdatedAt;

    /**
     * @param  array<string, ?string>  $filters
     */
    public function __construct(array $filters)
    {
        parent::__construct([
            'identifier' => FilterValueType::STRING,
            'name' => FilterValueType::STRING,
            'created_at' => FilterValueType::DATE,
            'updated_at' => FilterValueType::DATE,
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
