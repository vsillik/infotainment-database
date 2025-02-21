<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Filters\Traits\FilterEmail;
use App\Filters\Traits\FilterName;
use App\Filters\Traits\FilterUserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Filter<User>
 */
class DeletedUsersFilter extends Filter
{
    /**
     * @use FilterEmail<User>
     * @use FilterName<User>
     * @use FilterUserRole<User>
     */
    use FilterEmail, FilterName, FilterUserRole;

    public function __construct(array $filters)
    {
        parent::__construct([
            'email' => FilterValueType::STRING,
            'name' => FilterValueType::STRING,
            'user_role' => FilterValueType::STRING,
            'deleted_at' => FilterValueType::DATE,
        ], $filters);
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    protected function filterDeletedAt(Builder $query, string $value): Builder
    {
        return $query->whereDate('deleted_at', $value);
    }
}
