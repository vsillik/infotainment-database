<?php

declare(strict_types=1);

namespace App\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait FilterCreated
{
    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    protected function filterCreatedFrom(Builder $query, string $value): Builder
    {
        return $query->whereDate('created_at', '>=', $value);
    }

    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    protected function filterCreatedTo(Builder $query, string $value): Builder
    {
        return $query->whereDate('created_at', '<=', $value);
    }
}
