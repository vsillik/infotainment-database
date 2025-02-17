<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @template TModel of Model
 */
abstract class Filter
{
    /**
     * Filter name => value type (string|integer)
     *
     * @var array<string, FilterValueType>
     */
    protected readonly array $validFilterTypes;

    /**
     * Filter name => value (only validated filters)
     *
     * @var array<string, ?string>
     */
    protected readonly array $activeFilterValues;

    /**
     * @param  array<string, FilterValueType>  $validFilterTypes
     * @param  array<string, ?string>  $filters
     */
    public function __construct(
        array $validFilterTypes,
        array $filters
    ) {
        $this->validFilterTypes = $validFilterTypes;

        $activeFilters = [];

        foreach ($filters as $filterName => $value) {
            if (! $this->validateFilter($filterName, $value)) {
                continue;
            }

            $activeFilters[$filterName] = $value;
        }

        $this->activeFilterValues = $activeFilters;
    }

    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    public function apply(Builder $query): Builder
    {
        foreach ($this->activeFilterValues as $filterName => $value) {
            $methodName = $this->getMethodName($filterName);

            /** @var Builder<TModel> $query */
            $query = $this->{$methodName}($query, $value);
        }

        return $query;
    }

    public function isAnyFilterSet(): bool
    {
        return count($this->activeFilterValues) > 0;
    }

    protected function getMethodName(string $filterName): string
    {
        return 'filter'.Str::studly($filterName);
    }

    protected function validateFilter(string $filterName, mixed $value): bool
    {
        if (! array_key_exists($filterName, $this->validFilterTypes)) {
            return false;
        }

        $type = $this->validFilterTypes[$filterName];

        if (! $type->validateValueType($value)) {
            return false;
        }

        $method = $this->getMethodName($filterName);
        if (! method_exists($this, $method)) {
            return false;
        }

        return true;
    }
}
