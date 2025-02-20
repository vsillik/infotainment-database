<?php

declare(strict_types=1);

namespace App\Filters\Traits;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait ContainsString
{
    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    protected function columnContainsString(Builder $query, string|Expression $columnName, string $value): Builder
    {
        return $query->whereLike($columnName, '%'.$value.'%');
    }
}
