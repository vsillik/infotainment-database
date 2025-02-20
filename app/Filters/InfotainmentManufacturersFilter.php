<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Models\InfotainmentManufacturer;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Filter<InfotainmentManufacturer>
 */
class InfotainmentManufacturersFilter extends Filter
{
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

    /**
     * @param  Builder<InfotainmentManufacturer>  $query
     * @return Builder<InfotainmentManufacturer>
     */
    protected function filterName(Builder $query, string $value): Builder
    {
        return $query->whereLike('name', '%'.$value.'%');
    }

    /**
     * @param  Builder<InfotainmentManufacturer>  $query
     * @return Builder<InfotainmentManufacturer>
     */
    protected function filterCreatedAt(Builder $query, string $value): Builder
    {
        return $query->whereDate('created_at', $value);
    }

    /**
     * @param  Builder<InfotainmentManufacturer>  $query
     * @return Builder<InfotainmentManufacturer>
     */
    protected function filterUpdatedAt(Builder $query, string $value): Builder
    {
        return $query->whereDate('updated_at', $value);
    }
}
