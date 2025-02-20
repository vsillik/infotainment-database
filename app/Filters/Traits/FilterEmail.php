<?php

declare(strict_types=1);

namespace App\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait FilterEmail
{
    /**
     * @use ContainsString<TModel>
     */
    use ContainsString;

    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    protected function filterEmail(Builder $query, string $value): Builder
    {
        return $this->columnContainsString($query, 'email', $value);
    }
}
