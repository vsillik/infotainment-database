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
final class UsersFilter extends Filter
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
            'approved' => FilterValueType::YES_NO_CHOICE,
            'name' => FilterValueType::STRING,
            'user_role' => FilterValueType::USER_ROLE,
        ], $filters);
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
}
