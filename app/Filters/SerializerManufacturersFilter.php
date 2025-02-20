<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Models\SerializerManufacturer;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Filter<SerializerManufacturer>
 */
final class SerializerManufacturersFilter extends Filter
{
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
        return $query->whereLike('id', '%'.$value.'%');
    }

    /**
     * @param  Builder<SerializerManufacturer>  $query
     * @return Builder<SerializerManufacturer>
     */
    protected function filterName(Builder $query, string $value): Builder
    {
        return $query->whereLike('name', '%'.$value.'%');
    }

    /**
     * @param  Builder<SerializerManufacturer>  $query
     * @return Builder<SerializerManufacturer>
     */
    protected function filterCreatedAt(Builder $query, string $value): Builder
    {
        return $query->whereDate('created_at', $value);
    }

    /**
     * @param  Builder<SerializerManufacturer>  $query
     * @return Builder<SerializerManufacturer>
     */
    protected function filterUpdatedAt(Builder $query, string $value): Builder
    {
        return $query->whereDate('updated_at', $value);
    }
}
