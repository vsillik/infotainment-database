<?php

namespace App\Enums;

enum FilterValueType: string
{
    case STRING = 'string';

    case NUMERIC = 'numeric';

    case DATE = 'date';

    case USER_ROLE = 'user_role';

    case YES_NO_CHOICE = 'yes_no_choice';

    public function validateValueType(mixed $value): bool
    {
        return match ($this) {
            self::STRING, self::DATE => is_string($value) && $value !== '',
            self::YES_NO_CHOICE => is_string($value) && in_array($value, ['yes', 'no', 'any']),
            self::USER_ROLE => $value === 'any' || (is_numeric($value) && UserRole::tryFrom(intval($value)) !== null),
            self::NUMERIC => is_numeric($value),
        };
    }
}
