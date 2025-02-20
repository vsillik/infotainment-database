<?php

declare(strict_types=1);

namespace App\Filters\Traits;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait FilterUserRole
{
    /**
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    protected function filterUserRole(Builder $query, string $value): Builder
    {
        return $query->where('role', UserRole::from(intval($value))->value);
    }
}
