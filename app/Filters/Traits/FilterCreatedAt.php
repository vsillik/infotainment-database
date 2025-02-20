<?php

declare(strict_types=1);

namespace App\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait FilterCreatedAt
{
    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    protected function filterCreatedAt(Builder $query, string $value): Builder
    {
        return $query->whereDate('created_at', $value);
    }
}
