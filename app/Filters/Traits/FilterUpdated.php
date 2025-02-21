<?php

declare(strict_types=1);

namespace App\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait FilterUpdated
{
    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    protected function filterUpdatedFrom(Builder $query, string $value): Builder
    {
        return $query->whereDate('updated_at', '>=', $value);
    }

    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    protected function filterUpdatedTo(Builder $query, string $value): Builder
    {
        return $query->whereDate('updated_at', '<=', $value);
    }
}
