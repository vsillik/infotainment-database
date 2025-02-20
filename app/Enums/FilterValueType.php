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
            self::STRING, self::DATE => is_string($value) && ! empty($value),
            self::YES_NO_CHOICE => is_string($value) && in_array($value, ['yes', 'no']),
            self::USER_ROLE => is_numeric($value) && UserRole::tryFrom(intval($value)) !== null,
            self::NUMERIC => is_numeric($value),
        };
    }
}
