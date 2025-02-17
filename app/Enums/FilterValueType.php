<?php

namespace App\Enums;

enum FilterValueType: string
{
    case STRING = 'string';

    case NUMERIC = 'numeric';

    case DATE = 'date';

    public function validateValueType(mixed $value): bool
    {
        return match ($this) {
            self::STRING, self::DATE => is_string($value) && ! empty($value),
            self::NUMERIC => is_numeric($value),
        };
    }
}
