<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Filters\Exceptions\InvalidFilterValueException;
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
     *
     * @throws InvalidFilterValueException
     */
    use FilterEmail, FilterName, FilterUserRole;

    public function __construct(array $filters)
    {
        parent::__construct([
            'email' => FilterValueType::STRING,
            'name' => FilterValueType::STRING,
            'user_role' => FilterValueType::USER_ROLE,
            'deleted_from' => FilterValueType::DATE,
            'deleted_to' => FilterValueType::DATE,
        ], $filters);
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    protected function filterDeletedFrom(Builder $query, string $value): Builder
    {
        return $query->whereDate('deleted_at', '>=', $value);
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    protected function filterDeletedTo(Builder $query, string $value): Builder
    {
        return $query->whereDate('deleted_at', '<=', $value);
    }
}
