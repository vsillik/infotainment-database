<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\FilterValueType;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Filter<User>
 */
final class UsersFilter extends Filter
{
    public function __construct(array $filters)
    {
        parent::__construct([
            'email' => FilterValueType::STRING,
            'approved' => FilterValueType::YES_NO_CHOICE,
            'name' => FilterValueType::STRING,
            'user_role' => FilterValueType::USER_ROLE,
        ], $filters);
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    protected function filterEmail(Builder $query, string $value): Builder
    {
        return $query->whereLike('email', '%'.$value.'%');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    protected function filterApproved(Builder $query, string $value): Builder
    {
        $isApproved = $value === 'yes';

        return $query->where('is_approved', $isApproved);
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    protected function filterName(Builder $query, string $value): Builder
    {
        return $query->whereLike('name', '%'.$value.'%');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    protected function filterUserRole(Builder $query, string $value): Builder
    {
        return $query->where('role', UserRole::from(intval($value))->value);
    }
}
