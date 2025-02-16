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
    protected array $validFilters = [];

    /**
     * @param  Builder<TModel>  $query
     * @param  array<string, string|null>  $filters
     * @return Builder<TModel>
     */
    public function apply(Builder $query, array $filters): Builder
    {
        foreach ($filters as $filterName => $value) {
            if (! $this->validateFilter($filterName, $value)) {
                continue;
            }

            $methodName = $this->getMethodName($filterName);

            /** @var Builder<TModel> $query */
            $query = $this->{$methodName}($query, $value);
        }

        return $query;
    }

    /**
     * @param array<string, string|null> $filters
     */
    public function isAnyFilterSet(array $filters): bool
    {
        foreach ($filters as $filterName => $value) {
            if ($this->validateFilter($filterName, $value)) {
                return true;
            }
        }

        return false;
    }

    protected function getMethodName(string $filterName): string
    {
        return 'filter'.Str::studly($filterName);
    }

    protected function validateFilter(string $filterName, mixed $value): bool
    {
        if (! array_key_exists($filterName, $this->validFilters)) {
            return false;
        }

        $type = $this->validFilters[$filterName];

        if (! $type->validateType($value)) {
            return false;
        }

        $method = $this->getMethodName($filterName);
        if (! method_exists($this, $method)) {
            return false;
        }

        return true;
    }
}
