<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Filters\Exceptions\InvalidFilterValueException;
use App\Filters\Traits\ContainsString;
use App\Models\Infotainment;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Filter<Infotainment>
 */
class InfotainmentsFilter extends Filter
{
    /**
     * @use ContainsString<Infotainment>
     */
    use ContainsString;

    /**
     * @param  array<string, ?string>  $filters
     *
     * @throws InvalidFilterValueException
     */
    public function __construct(array $filters)
    {
        parent::__construct([
            'infotainment_manufacturer_name' => FilterValueType::STRING,
            'serializer_manufacturer_name' => FilterValueType::STRING,
            'product_id' => FilterValueType::STRING,
            'model_year_from' => FilterValueType::NUMERIC,
            'model_year_to' => FilterValueType::NUMERIC,
            'part_number' => FilterValueType::STRING,
        ], $filters);
    }

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
        return $this->columnContainsString($query, 'product_id', $value);
    }

    /**
     * @param  Builder<Infotainment>  $query
     * @return Builder<Infotainment>
     */
    protected function filterModelYearFrom(Builder $query, string $value): Builder
    {
        return $query->where('model_year', '>=', $value);
    }

    /**
     * @param  Builder<Infotainment>  $query
     * @return Builder<Infotainment>
     */
    protected function filterModelYearTo(Builder $query, string $value): Builder
    {
        return $query->where('model_year', '<=', $value);
    }

    /**
     * @param  Builder<Infotainment>  $query
     * @return Builder<Infotainment>
     */
    protected function filterPartNumber(Builder $query, string $value): Builder
    {
        return $this->columnContainsString($query, 'part_number', $value);
    }
}
