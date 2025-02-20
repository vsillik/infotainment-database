<?php

declare(strict_types=1);

namespace App\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait FilterName
{
    /**
     * @use ContainsString<TModel>
     */
    use ContainsString;

    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    protected function filterName(Builder $query, string $value): Builder
    {
        return $this->columnContainsString($query, 'name', $value);
    }
}
