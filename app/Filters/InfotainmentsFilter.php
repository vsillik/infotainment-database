<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Models\Infotainment;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Filter<Infotainment>
 */
class InfotainmentsFilter extends Filter
{
    /**
     * @var array<string, FilterValueType>
     */
    protected array $validFilters = [
        'infotainment_manufacturer_name' => FilterValueType::STRING,
        'serializer_manufacturer_name' => FilterValueType::STRING,
        'product_id' => FilterValueType::STRING,
        'model_year' => FilterValueType::NUMERIC,
        'part_number' => FilterValueType::STRING,
    ];

    /**
     * @param  Builder<Infotainment>  $query
     * @return Builder<Infotainment>
     */
    protected function filterInfotainmentManufacturerName(Builder $query, string $value): Builder
    {
        return $query->whereHas('infotainmentManufacturer', function (Builder $query) use ($value) {
            $query->whereLike('name', '%'.$value.'%');
        });
    }

    /**
     * @param  Builder<Infotainment>  $query
     * @return Builder<Infotainment>
     */
    protected function filterSerializerManufacturerName(Builder $query, string $value): Builder
    {
        return $query->whereHas('serializerManufacturer', function (Builder $query) use ($value) {
            $query->whereLike('name', '%'.$value.'%');
        });
    }

    /**
     * @param  Builder<Infotainment>  $query
     * @return Builder<Infotainment>
     */
    protected function filterProductId(Builder $query, string $value): Builder
    {
        return $query->whereLike('product_id', '%'.$value.'%');
    }

    /**
     * @param  Builder<Infotainment>  $query
     * @return Builder<Infotainment>
     */
    protected function filterModelYear(Builder $query, string $value): Builder
    {
        return $query->where('model_year', $value);
    }

    /**
     * @param  Builder<Infotainment>  $query
     * @return Builder<Infotainment>
     */
    protected function filterPartNumber(Builder $query, string $value): Builder
    {
        return $query->whereLike('part_number', '%'.$value.'%');
    }
}
